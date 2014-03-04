<?php

namespace Kristofvc\ListBundle\Model;

use Doctrine\ODM\MongoDB\Query\Builder;

abstract class ODMFilter extends Filter
{
    public function addFilterToBuilder(Builder &$qb, $id, $data)
    {
        $this->data[$id] = $data;
        $this->addFilter($qb, $id, $data);
    }

    abstract public function addFilter(Builder &$qb, $id, $data);
}
