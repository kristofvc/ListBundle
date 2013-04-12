<?php

namespace Kristofvc\ListBundle\Model\Filters;

use Doctrine\ORM\QueryBuilder;
use Kristofvc\ListBundle\Model\Filter;

class DateFilter extends Filter
{

    const COMP_BEFORE = 'before';
    const COMP_AFTER = 'after';

    public function addFilter(QueryBuilder &$qb, $id, $data)
    {
        switch ($data['comparator']) {
            case self::COMP_BEFORE:
                $qb->andWhere($qb->expr()->lte('i.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, $data['value']);
                break;
            case self::COMP_AFTER:
                $qb->andWhere($qb->expr()->gte('i.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, $data['value']);
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