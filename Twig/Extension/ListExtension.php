<?php

namespace Kristofvc\ListBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Kristofvc\ListBundle\Builder\ListBuilder;

class ListExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions()
    {
        return array(
            'renderList'  => new \Twig_Function_Method($this, 'renderList', array('is_safe' => array('html'))),
        );
    }

    public function renderList($service, array $params = array()){
        $itemconfiguration = $this->container->get($service);
        $request = $this->container->get('request');
        
        $route = $request->get('_route');        
        $routeParams = $request->query->all();
        
        $builder = new ListBuilder($this->container, $itemconfiguration, $params);
        $builder->getFilterBuilder()->analyzeFilters($this->container->get('request'), $itemconfiguration);
        $itempagination = $builder->getPagination();     
        
        $template = $this->environment->loadTemplate("KristofvcListBundle:ListExtension:renderList.html.twig");
        
        return $template->render(array_merge($params, array(
            'builder' => $builder,
            'pagination' => $itempagination,
            'params' => $builder->getParams(),
            'route' => $route,
            'routeParams' => $routeParams
        )));
    }
    
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'list_extension';
    }
}