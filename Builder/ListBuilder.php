<?php

namespace Kristofvc\ListBundle\Builder;

use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Paginator;
use Kristofvc\ListBundle\Configuration\AbstractListConfiguration;
use Symfony\Component\HttpFoundation\Request;

class ListBuilder
{
    protected $configuration;
    protected $request;
    protected $paginator;
    protected $filterBuilder;
    protected $definedFilters = array();
    protected $objectManager;
    protected $defaultParams = array();
    protected $params = array();

    public function __construct(Request $request, Paginator $paginator, AbstractListConfiguration $configuration, ManagerRegistry $om, $defaultParams = array(), $params = array())
    {
        $this->request = $request;
        $this->paginator = $paginator;
        $this->configuration = $configuration;
        $this->filterBuilder = new FilterBuilder();
        $this->objectManager = $om;

        $this->defaultParams = $defaultParams;
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
        return $this->defaultParams;
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
        $this->filterBuilder->analyzeFilters($this->request, $this->configuration);
        return $this;
    }

    public function getPagination()
    {
        $pagination = $this->paginator->paginate(
            $this->getQuery(),
            $this->request->query->get($this->params['page_parameter_name'], 1),
            $this->params['items_per_page'],
            array(
                'pageParameterName' => $this->params['page_parameter_name']
            )
        );

        return $pagination;
    }

    public function getQuery()
    {
        return $this->configuration->getQuery($this->objectManager, $this->filterBuilder);
    }
}
