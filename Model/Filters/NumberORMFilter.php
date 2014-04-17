<?php

namespace Kristofvc\ListBundle\Model\Filters;

use Doctrine\ORM\QueryBuilder;
use Kristofvc\ListBundle\Model\ORMFilter;

class NumberORMFilter extends ORMFilter
{
    const COMP_EQUALS = 'equals';
    const COMP_BEFORE = 'before';
    const COMP_AFTER = 'after';
    const COMP_EQUALSBEFORE = 'equalsbefore';
    const COMP_EQUALSAFTER = 'equalsafter';

    public function addFilter(QueryBuilder &$qb, $id, $data)
    {
        if (isset($data['value'])) {
            switch ($data['comparator']) {
                case self::COMP_EQUALS:
                    $qb->andWhere($qb->expr()->eq($this->identifier . '.' . $this->field, ':var_' . $id))
                       ->setParameter('var_' . $id, $data['value']);
                    break;
                case self::COMP_BEFORE:
                    $qb->andWhere($qb->expr()->lt($this->identifier . '.' . $this->field, ':var_' . $id))
                       ->setParameter('var_' . $id, $data['value']);
                    break;
                case self::COMP_AFTER:
                    $qb->andWhere($qb->expr()->gt($this->identifier . '.' . $this->field, ':var_' . $id))
                       ->setParameter('var_' . $id, $data['value']);
                    break;
                case self::COMP_EQUALSBEFORE:
                    $qb->andWhere($qb->expr()->lte($this->identifier . '.' . $this->field, ':var_' . $id))
                       ->setParameter('var_' . $id, $data['value']);
                    break;
                case self::COMP_EQUALSAFTER:
                    $qb->andWhere($qb->expr()->gte($this->identifier . '.' . $this->field, ':var_' . $id))
                       ->setParameter('var_' . $id, $data['value']);
                    break;
            }
        }
    }

    public function getTemplate()
    {
        return 'KristofvcListBundle:Filters:numberFilter.html.twig';
    }

    public function getDataFields()
    {
        return array('value', 'comparator');
    }
}
