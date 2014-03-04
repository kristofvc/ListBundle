<?php

namespace Kristofvc\ListBundle\Model;

class Column
{
    protected $name;
    protected $columnHeader;
    protected $sortIdentifier;
    protected $sortable;
    protected $sortField;
    protected $route;
    protected $routeParams;
    protected $emptyValue;
    protected $parentField;
    protected $params;
    protected $boolean;
    protected $booleanValue;
    protected $prefix;
    protected $suffix;

    public function __construct($name, $columnHeader, $params = array())
    {
        // 'sortable' => false, 'sortField' => null, 'route' => null, 'routeParams' => null, 'column_empty_value' => null

        $this->name = $name;
        $this->columnHeader = $columnHeader;

        $this->sortIdentifier = isset($params['sortIdentifier']) ? $params['sortIdentifier'] : 'i';

        $this->sortable = isset($params['sortable']) ? $params['sortable'] : false;
        if (isset($params['sortField']) && !is_null($params['sortField'])) {
            $this->sortField = $this->sortIdentifier . '.' . $params['sortField'];
        } else {
            $this->sortField = $this->sortIdentifier . '.' . lcfirst($this->name);
        }

        $this->prefix = isset($params['prefix']) ? $params['prefix'] : '';
        $this->suffix = isset($params['suffix']) ? $params['suffix'] : '';

        $this->boolean = isset($params['boolean']) ? $params['boolean'] : false;
        $this->booleanValue = isset($params['boolean_value']) ? $params['boolean_value'] : array();

        $this->route = isset($params['route']) ? $params['route'] : null;
        $this->routeParams = isset($params['routeParams']) ? $params['routeParams'] : null;

        $this->emptyValue = isset($params['column_empty_value']) ? $params['column_empty_value'] : null;
        $this->parentField = isset($params['parentField']) ? $params['parentField'] : null;

        $this->params = $params;
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

    /**
     * @param string $sortIdentifier
     * @return Column
     */
    public function setSortIdentifier($sortIdentifier)
    {
        $this->sortIdentifier = $sortIdentifier;
        return $this;
    }

    /**
     * @return string
     */
    public function getSortIdentifier()
    {
        return $this->sortIdentifier;
    }

    public function isBoolean()
    {
        return $this->boolean;
    }

    public function getBooleanValue()
    {
        return $this->booleanValue;
    }

    /**
     * @param mixed $prefix
     * @return Column
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param mixed $suffix
     * @return Column
     */
    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuffix()
    {
        return $this->suffix;
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

    public function getEmptyValue()
    {
        return $this->emptyValue;
    }

    public function setEmptyValue($emptyValue)
    {
        $this->emptyValue = $emptyValue;
        return $this;
    }

    public function getParentField()
    {
        return $this->parentField;
    }

    public function setParentField($parentField)
    {
        $this->parentField = $parentField;
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }
}
