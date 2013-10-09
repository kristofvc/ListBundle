<?php

namespace Kristofvc\ListBundle\Configuration;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Kristofvc\ListBundle\Builder\FilterBuilder;

abstract class AbstractListORMConfiguration extends AbstractListConfiguration
{
    public function buildQuery(QueryBuilder &$qb)
    {
        return $this;
    }

    public function getQuery(ManagerRegistry $om, FilterBuilder $filterbuilder)
    {
        $qb = $om->getManager()->createQueryBuilder();
        $qb->select('i')->from($this->getRepository(), 'i');

        $this->buildQuery($qb);
        $filterbuilder->addFilters($qb, $this);

        return $qb->getQuery();
    }
}
