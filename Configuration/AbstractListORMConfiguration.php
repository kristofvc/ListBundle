<?php

namespace Kristofvc\ListBundle\Configuration;

use Doctrine\ORM\QueryBuilder;

abstract class AbstractListORMConfiguration extends AbstractListConfiguration
{
    public function buildQuery(QueryBuilder &$qb)
    {
        return $this;
    }

    public function getQuery($container, $filterbuilder, $configuration)
    {
        $em = $container->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('i')->from($configuration->getRepository(), 'i');

        $this->buildQuery($qb);
        $filterbuilder->addFilters($qb, $configuration);

        return $qb->getQuery();
    }
}
