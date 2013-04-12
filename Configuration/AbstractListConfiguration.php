<?php

namespace Kristofvc\ListBundle\Configuration;

use Kristofvc\ListBundle\Model\Column;
use Kristofvc\ListBundle\Model\Action;
use Kristofvc\ListBundle\Model\Filter;

abstract class AbstractListConfiguration
{

    protected $columns = array();
    protected $actions = array();
    protected $filters = array();
    protected $filterFields = array();

    public function getColumns()
    {
        return $this->columns;
    }

    public function addColumn(Column $column)
    {
        $this->columns[] = $column;
        return $this;
    }

    public function getActions()
    {
        return $this->actions;
    }

    public function addAction(Action $action)
    {
        $this->actions[] = $action;
        return $this;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function addFilter(Filter $filter)
    {
        $this->filterFields = array_merge($this->filterFields, $filter->getDataFields());

        $this->filters[] = $filter;
        return $this;
    }

    public function getFilterFields()
    {
        return $this->filterFields;
    }

    abstract public function buildColumns();

    abstract public function buildActions();

    abstract public function buildFilters();

    abstract public function getRepository();

    public function buildQuery(&$qb)
    {
        
    }

    public function getDefaultParams()
    {
        return array();
    }

}