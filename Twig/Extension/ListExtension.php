<?php

namespace Kristofvc\ListBundle\Twig\Extension;

use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\Paginator;
use Kristofvc\ListBundle\Helper\RenderingHelper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Kristofvc\ListBundle\Builder\ListBuilder;
use Symfony\Component\HttpFoundation\Request;

class ListExtension extends \Twig_Extension
{
    protected $container;
    protected $request;
    protected $objectManager;
    protected $defaultParams;
    protected $paginator;
    protected $renderingHelper;

    public function __construct(ContainerInterface $container, ManagerRegistry $om, Paginator $paginator, RenderingHelper $renderingHelper, $defaultParams = array())
    {
        $this->container = $container;
        $this->objectManager = $om;
        $this->paginator = $paginator;
        $this->renderingHelper = $renderingHelper;
        $this->defaultParams = $defaultParams;
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;
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
        if (null === $this->request) {
            throw new Exception('request not found.');
        }

        $service = $this->container->get($service);
        if (isset($params["extraConfigurationParams"])) {
            $service->setExtraParams($params["extraConfigurationParams"]);
        }

        $builder = new ListBuilder($this->request, $this->paginator, $service, $this->objectManager, $this->defaultParams, $params);
        $template = $this->environment->loadTemplate("KristofvcListBundle:ListExtension:renderList.html.twig");


        return $template->render(
            array_merge(
                $params,
                array(
                    'builder' => $builder,
                    'pagination' => $builder->getPagination(),
                    'params' => $builder->getParams(),
                    'route' => $this->request->get('_route'),
                    'routeParams' => array_merge($this->request->get('_route_params'), $this->request->query->all()),
                    'helper' => $this->renderingHelper
                )
            )
        );
    }

    public function getName()
    {
        return 'list_extension';
    }
}
