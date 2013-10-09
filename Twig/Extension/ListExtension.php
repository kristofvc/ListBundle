<?php

namespace Kristofvc\ListBundle\Twig\Extension;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Kristofvc\ListBundle\Builder\ListBuilder;

class ListExtension extends \Twig_Extension
{
    protected $container;
    protected $objectManager;

    public function __construct(ContainerInterface $container, ManagerRegistry $om)
    {
        $this->container = $container;
        $this->objectManager = $om;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions()
    {
        return array(
            'renderList' => new \Twig_Function_Method($this, 'renderList', array('is_safe' => array('html'))),
        );
    }

    public function renderList($service, array $params = array())
    {
        $service = $this->container->get($service);
        if (isset($params["extraConfigurationParams"])) {
            $service->setExtraParams($params["extraConfigurationParams"]);
        }

        $request = $this->container->get('request');
        $defaultParams = array(
            'list_template' => $this->container->getParameter('kristofvc_list.list_template'),
            'page_parameter_name' => $this->container->getParameter('kristofvc_list.page_parameter_name'),
            'items_per_page' => $this->container->getParameter('kristofvc_list.items_per_page'),
            'column_empty_value' => $this->container->getParameter('kristofvc_list.column_empty_value')
        );
        $builder = new ListBuilder($request, $this->container->get('knp_paginator'), $service, $this->objectManager, $defaultParams, $params);
        $template = $this->environment->loadTemplate("KristofvcListBundle:ListExtension:renderList.html.twig");


        return $template->render(
            array_merge(
                $params,
                array(
                    'builder' => $builder,
                    'pagination' => $builder->getPagination(),
                    'params' => $builder->getParams(),
                    'route' => $request->get('_route'),
                    'routeParams' => array_merge($request->get('_route_params'), $request->query->all()),
                    'helper' => $this->container->get('rendering.helper')
                )
            )
        );
    }

    public function getName()
    {
        return 'list_extension';
    }
}
