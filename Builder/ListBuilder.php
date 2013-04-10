<?php

namespace Kristofvc\ListBundle\Builder;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\PersistentCollection;
use Kristofvc\ListBundle\Configuration\AbstractListConfiguration;
use Kristofvc\ListBundle\Model\Column;
use Kristofvc\ListBundle\Model\Action;

class ListBuilder
{

    protected $container;
    protected $configuration;
    
    protected $filterBuilder;
    protected $definedFilters = array();
    
    protected $params;

    public function __construct(ContainerInterface $container, AbstractListConfiguration $configuration, $params)
    {
        $this->container = $container;
        $this->configuration = $configuration;
        
        $this->filterBuilder = new FilterBuilder();
        
        $this->configuration->buildColumns();
        $this->configuration->buildActions();
        $this->configuration->buildFilters();
        
        $this->mergeParams($params);
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function getFilterBuilder()
    {
        return $this->filterBuilder;
    }
    
    public function getParams()
    {
        return $this->params;
    }
    
    public function getQuery()
    {
        $em = $this->container->get('doctrine')->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('i')
                ->from($this->configuration->getRepository(), 'i');

        $this->configuration->buildQuery($qb);
        
        $this->filterBuilder->addFilters($qb, $this->configuration);
        
        return $qb->getQuery();
    }

    public function getPagination()
    {
        $paginator = $this->container->get('knp_paginator');

        $pagination = $paginator->paginate(
                $this->getQuery(), $this->container->get('request')->query->get($this->params['pageParameterName'], 1), $this->params['nbItems'], array('pageParameterName' => $this->params['pageParameterName'])
        );

        return $pagination;
    }

    public function getValue($item, $columnName)
    {
        if (method_exists($item, $columnName)) {
            $result = $item->$columnName();
        } elseif (method_exists($item, 'get' . $columnName)) {
            $method = 'get' . $columnName;
            $result = $item->$method();
        } elseif (method_exists($item, 'is' . $columnName)) {
            $method = 'is' . $column->getName();
            $result = $item->$method();
        } elseif (method_exists($item, 'has' . $columnName)) {
            $method = 'has' . $columnName;
            $result = $item->$method();
        } else {
            return '';
        }

        return $result;
    }

    public function renderValue($item, Column $column)
    {
        $value = $this->getValue($item, $column->getName());

        if (empty($value)) {
            return '';
        }

        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }

        if ($value instanceof PersistentCollection) {
            $pieces = array();
            foreach ($value as $piece) {
                $pieces[] = $piece;
            }
            return implode(', ', $pieces);
        }

        return $value;
    }

    public function getRouteParams($item, Action $action)
    {
        $routeParams = array();

        foreach ($action->getRouteParams() as $param) {
            $routeParams[strtolower($param)] = $this->getValue($item, $param);
        }

        return $routeParams;
    }
    
    public function getDefaultParams(){
        return array(
            'template' => $this->container->getParameter('kristofvc_list.list_template'),
            'pageParameterName'  => $this->container->getParameter('kristofvc_list.page_parameter_name'),
            'nbItems' => $this->container->getParameter('kristofvc_list.items_per_page')
        );
    }
    
    public function mergeParams(array $params){
        $defaultParams = $this->getDefaultParams();
        foreach($defaultParams as $key => $value){
            if(isset($params[$key])){
                $defaultParams[$key] = $params[$key];
            }
        }
        $this->params = $defaultParams;
        return $this;
    }

}