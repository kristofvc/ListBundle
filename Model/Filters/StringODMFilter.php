<?php

namespace Kristofvc\ListBundle\Model\Filters;

use Doctrine\ODM\MongoDB\Query\Builder;
use Kristofvc\ListBundle\Model\ODMFilter;

class StringODMFilter extends ODMFilter
{
    const COMP_EQUALS = 'equals';
    const COMP_DOESNOTEQUAL = 'doesnotequal';
    const COMP_CONTAINS = 'contains';
    const COMP_DOESNOTCONTAIN = 'doesnotcontain';
    const COMP_STARTSWITH = 'startswith';
    const COMP_ENDSWITH = 'endswith';

    public function addFilter(Builder &$qb, $id, $data)
    {
        switch ($data['comparator']) {
            case self::COMP_EQUALS:
                $qb->field($this->field)->equals($data['value']);
                break;
            case self::COMP_DOESNOTEQUAL:
                $qb->field($this->field)->notEqual($data['value']);
                break;
            case self::COMP_CONTAINS:
                $mongoregex = new \MongoRegex("/.*".$data['value'].".*/i");
                $qb->field($this->field)->equals($mongoregex);
                break;
            case self::COMP_DOESNOTCONTAIN:
                $mongoregex = new \MongoRegex("/.*".$data['value'].".*/i");
                $qb->field($this->field)->not($mongoregex);
                break;
            case self::COMP_STARTSWITH:
                $mongoregex = new \MongoRegex("/^".$data['value']."/i");
                $qb->field($this->field)->equals($mongoregex);
                break;
            case self::COMP_ENDSWITH:
                $mongoregex = new \MongoRegex("/.*".$data['value']."$/i");
                $qb->field($this->field)->equals($mongoregex);
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
