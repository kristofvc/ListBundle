<?php

namespace Kristofvc\ListBundle\Model;

class Column
{

    protected $name;
    protected $columnHeader;
    protected $sortable;
    protected $sortField;
    protected $route;
    protected $routeParams;

    public function __construct($name, $columnHeader, $sortable = false, $sortField = null, $route = null, $routeParams = null)
    {
        $this->name = $name;
        $this->columnHeader = $columnHeader;

        $this->sortable = $sortable;
        if (!is_null($sortField)) {
            $this->sortField = $sortField;
        } else {
            $this->sortField = lcfirst($this->name);
        }

        $this->route = $route;
        $this->routeParams = $routeParams;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getColumnHeader()
    {
        return $this->columnHeader;
    }

    public function setColumnHeader($columnHeader)
    {
        $this->columnHeader = $columnHeader;
        return $this;
    }

    public function getSortField()
    {
        return $this->sortField;
    }

    public function setSortField($field)
    {
        $this->sortField = $field;
        return $this;
    }

    public function isSortable()
    {
        return $this->sortable;
    }

    public function setSortable($sortable)
    {
        $this->sortable = $sortable;
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setRoute($route)
    {
        $this->route = $route;
    }

    public function getRouteParams()
    {
        return $this->routeParams;
    }

    public function setRouteParams($routeParams)
    {
        $this->routeParams = $routeParams;
    }

}