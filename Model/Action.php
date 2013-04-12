<?php

namespace Kristofvc\ListBundle\Model;

class Action
{

    protected $name;
    protected $route;
    protected $routeParams;
    protected $icon;
    protected $iconWhite;
    protected $btnColour;
    protected $modal;
    protected $modalParams;

    public function __construct($name, $route, $routeParams = array(), $icon = null, $iconWhite = false, $btnColour = null, $modal = false, $modalParams = array())
    {
        $this->name = $name;
        $this->route = $route;
        $this->routeParams = $routeParams;
        $this->icon = $icon;
        $this->iconWhite = $iconWhite;
        $this->btnColour = $btnColour;
        $this->modal = $modal;
        $this->modalParams = $modalParams;
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

    public function getRoute()
    {
        return $this->route;
    }

    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }

    public function getRouteParams()
    {
        return $this->routeParams;
    }

    public function setRouteParams($routeParams)
    {
        $this->routeParams = $routeParams;
        return $this;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    public function getIconWhite()
    {
        return $this->iconWhite;
    }

    public function setIconWhite($iconWhite)
    {
        $this->iconWhite = $iconWhite;
        return $this;
    }

    public function getBtnColour()
    {
        return $this->btnColour;
    }

    public function setBtnColour($btnColour)
    {
        $this->btnColour = $btnColour;
        return $this;
    }

    public function getModal()
    {
        return $this->modal;
    }

    public function setModal($modal)
    {
        $this->modal = $modal;
        return $this;
    }

    public function getModalParams()
    {
        return $this->modalParams;
    }

    public function setModalParams($modalParams)
    {
        $this->modalParams = $modalParams;
        return $this;
    }

}