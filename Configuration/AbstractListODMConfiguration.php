<?php

namespace Kristofvc\ListBundle\Configuration;

use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;

abstract class AbstractListODMConfiguration extends AbstractListConfiguration
{
    public function buildQuery(QueryBuilder &$qb)
    {
        return $this;
    }

    public function getQuery($container, $filterbuilder, $configuration)
    {
        $em = $container->get('doctrine_mongodb')->getManager();
        $qb = $em->createQueryBuilder($configuration->getRepository());

        $this->buildQuery($qb);
        $filterbuilder->addFilters($qb, $configuration);

        return $qb->getQuery();
    }
}
