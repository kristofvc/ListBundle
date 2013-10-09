<?php

namespace Kristofvc\ListBundle\Builder;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Kristofvc\ListBundle\Configuration\AbstractListConfiguration;

class ListBuilder
{
    protected $container;
    protected $configuration;
    protected $filterBuilder;
    protected $definedFilters = array();
    protected $params = array();

    public function __construct(ContainerInterface $container, AbstractListConfiguration $configuration, $params)
    {
        $this->container = $container;
        $this->configuration = $configuration;
        $this->filterBuilder = new FilterBuilder();

        $this->mergeParams($params)
             ->buildList();
        
        foreach ($this->configuration->getColumns() as $column) {
            $emptyValue = $column->getEmptyValue();
            if (empty($emptyValue)) {
                $column->setEmptyValue($this->params['column_empty_value']);
            }
        }
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

    public function getDefaultParams()
    {
        return array(
            'list_template' => $this->container->getParameter('kristofvc_list.list_template'),
            'page_parameter_name' => $this->container->getParameter('kristofvc_list.page_parameter_name'),
            'items_per_page' => $this->container->getParameter('kristofvc_list.items_per_page'),
            'column_empty_value' => $this->container->getParameter('kristofvc_list.column_empty_value')
        );
    }

    public function mergeParams(array $params)
    {
        $defaultParams = $this->getDefaultParams();
        $configurationParams = $this->configuration->getDefaultParams();

        foreach ($configurationParams as $key => $value) {
            $defaultParams[$key] = $configurationParams[$key];
        }

        foreach ($params as $key => $value) {
            $defaultParams[$key] = $value;
        }

        $this->params = $defaultParams;
        return $this;
    }

    public function buildList()
    {
        $this->configuration->buildColumns();
        $this->configuration->buildActions();
        $this->configuration->buildFilters();
        $this->filterBuilder->analyzeFilters($this->container->get('request'), $this->configuration);
        return $this;
    }

    public function getPagination()
    {
        $paginator = $this->container->get('knp_paginator');
        $pagination = $paginator->paginate(
            $this->getQuery(),
            $this->container->get('request')->query->get($this->params['page_parameter_name'], 1),
            $this->params['items_per_page'],
            array(
                'pageParameterName' => $this->params['page_parameter_name']
            )
        );

        return $pagination;
    }

    public function getQuery()
    {
        return $this->configuration->getQuery($this->container, $this->filterBuilder, $this->configuration);
    }
}
