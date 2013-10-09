<?php

namespace Kristofvc\ListBundle\Configuration;

use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;

abstract class AbstractListODMConfiguration extends AbstractListConfiguration
{
    public function buildQuery(QueryBuilder &$qb)
    {
        return $this;
    }

    public function getQuery($container, $filterbuilder)
    {
        $em = $container->get('doctrine_mongodb')->getManager();

        $this->prefetch();

        $qb = $em->createQueryBuilder($this->getRepository());

        $this->buildQuery($qb);
        $filterbuilder->addFilters($qb, $this);

        return $qb->getQuery();
    }
}
