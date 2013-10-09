<?php

namespace Kristofvc\ListBundle\Configuration;

use Doctrine\ORM\QueryBuilder;

abstract class AbstractListORMConfiguration extends AbstractListConfiguration
{
    public function buildQuery(QueryBuilder &$qb)
    {
        return $this;
    }

    public function getQuery($container, $filterbuilder)
    {
        $em = $container->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('i')->from($this->getRepository(), 'i');

        $this->buildQuery($qb);
        $filterbuilder->addFilters($qb, $this);

        return $qb->getQuery();
    }
}
