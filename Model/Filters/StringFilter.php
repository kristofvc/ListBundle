<?php

namespace Kristofvc\ListBundle\Model\Filters;

use Doctrine\ORM\QueryBuilder;
use Kristofvc\ListBundle\Model\Filter;

class StringFilter extends Filter
{

    const COMP_EQUALS = 'equals';
    const COMP_DOESNOTEQUAL = 'doesnotequal';
    const COMP_CONTAINS = 'contains';
    const COMP_DOESNOTCONTAIN = 'doesnotcontain';
    const COMP_STARTSWITH = 'startswith';
    const COMP_ENDSWITH = 'endswith';

    public function addFilter(QueryBuilder &$qb, $id, $data)
    {
        switch ($data['comparator']) {
            case self::COMP_EQUALS:
                $qb->andWhere($qb->expr()->eq('i.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, $data['value']);
                break;
            case self::COMP_DOESNOTEQUAL:
                $qb->andWhere($qb->expr()->neq('i.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, $data['value']);
                break;
            case self::COMP_CONTAINS:
                $qb->andWhere($qb->expr()->like('i.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, '%' . $data['value'] . '%');
                break;
            case self::COMP_DOESNOTCONTAIN:
                $qb->andWhere('i.' . $this->field . ' NOT LIKE :var_' . $id)
                   ->setParameter('var_' . $id, '%' . $data['value'] . '%');
                break;
            case self::COMP_STARTSWITH:
                $qb->andWhere($qb->expr()->like('i.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, $data['value'] . '%');
                break;
            case self::COMP_ENDSWITH:
                $qb->andWhere($qb->expr()->like('i.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, '%' . $value);
                break;
        }
    }

    public function getTemplate()
    {
        return 'KristofvcListBundle:Filters:stringFilter.html.twig';
    }

    public function getDataFields()
    {
        return array('value', 'comparator');
    }

}