<?php

namespace Kristofvc\ListBundle\Model\Filters;

use Doctrine\ORM\QueryBuilder;
use Kristofvc\ListBundle\Model\ORMFilter;

class StringORMFilter extends ORMFilter
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
                $qb->andWhere($qb->expr()->eq($this->identifier . '.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, $data['value']);
                break;
            case self::COMP_DOESNOTEQUAL:
                $qb->andWhere($qb->expr()->neq($this->identifier . '.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, $data['value']);
                break;
            case self::COMP_CONTAINS:
                $qb->andWhere($qb->expr()->like($this->identifier . '.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, '%' . $data['value'] . '%');
                break;
            case self::COMP_DOESNOTCONTAIN:
                $qb->andWhere($this->identifier . '.' . $this->field . ' NOT LIKE :var_' . $id)
                   ->setParameter('var_' . $id, '%' . $data['value'] . '%');
                break;
            case self::COMP_STARTSWITH:
                $qb->andWhere($qb->expr()->like($this->identifier . '.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, $data['value'] . '%');
                break;
            case self::COMP_ENDSWITH:
                $qb->andWhere($qb->expr()->like($this->identifier . '.' . $this->field, ':var_' . $id))
                   ->setParameter('var_' . $id, '%' . $data['value']);
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
