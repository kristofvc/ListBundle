<?php

namespace Kristofvc\ListBundle\Configuration;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ODM\MongoDB\Query\Builder as QueryBuilder;
use Kristofvc\ListBundle\Builder\FilterBuilder;

abstract class AbstractListODMConfiguration extends AbstractListConfiguration
{
    public function buildQuery(QueryBuilder &$qb)
    {
        return $this;
    }

    public function getQuery(ManagerRegistry $om, FilterBuilder $filterbuilder)
    {
        $this->prefetch();

        $qb = $om->getManager()->createQueryBuilder($this->getRepository());

        $this->buildQuery($qb);
        $filterbuilder->addFilters($qb, $this);

        return $qb;
    }
}
