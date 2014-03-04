<?php

namespace Kristofvc\ListBundle\Model\Filters;

use Doctrine\ODM\MongoDB\Query\Builder;
use Kristofvc\ListBundle\Model\ODMFilter;

class DateODMFilter extends ODMFilter
{
    const COMP_BEFORE = 'before';
    const COMP_AFTER = 'after';

    public function addFilter(Builder &$qb, $id, $data)
    {
        switch ($data['comparator']) {
            case self::COMP_BEFORE:
                $qb->field($this->field)->lte($data['value']);
                break;
            case self::COMP_AFTER:
                $qb->field($this->field)->gte($data['value']);
                break;
        }
    }

    public function getTemplate()
    {
        return 'KristofvcListBundle:Filters:dateFilter.html.twig';
    }

    public function getDataFields()
    {
        return array('value', 'comparator');
    }
}
