<?php

namespace Kristofvc\ListBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Kristofvc\ListBundle\Builder\ListBuilder;

class ListExtension extends \Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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

        $builder = new ListBuilder($this->container, $service, $params);
        $template = $this->environment->loadTemplate("KristofvcListBundle:ListExtension:renderList.html.twig");
        $request = $this->container->get('request');

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
