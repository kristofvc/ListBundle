<?php

namespace Kristofvc\ListBundle\Model;

use Doctrine\DBAL\Query\QueryBuilder;

abstract class ORMFilter extends Filter
{
    public function addFilterToBuilder(QueryBuilder &$qb, $id, $data)
    {
        $this->data[$id] = $data;
        $this->addFilter($qb, $id, $data);
    }

    abstract public function addFilter(QueryBuilder &$qb, $id, $data);
}
