<?php

namespace Kristofvc\ListBundle\Model;

abstract class Filter
{
    protected $name;
    protected $field;
    protected $data;
    protected $identifier;

    public function __construct($name, $field, $identifier = 'i')
    {
        $this->name = $name;
        $this->field = $field;
        $this->identifier = $identifier;
        $this->data = array();
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

    public function getField()
    {
        return $this->field;
    }

    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
    
    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    abstract public function getTemplate();

    abstract public function getDataFields();
}
