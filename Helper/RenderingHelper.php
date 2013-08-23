<?php

namespace Kristofvc\ListBundle\Helper;

use Doctrine\ORM\PersistentCollection;

class RenderingHelper
{

    public function getValue($item, $columnName, $parentField = null)
    {
        if (!is_null($parentField)) {
            $item = $this->getValue($item, $parentField);
        }
        if (method_exists($item, $columnName)) {
            $value = $item->$columnName();
        } elseif (method_exists($item, 'get' . $columnName)) {
            $method = 'get' . $columnName;
            $value = $item->$method();
        } elseif (method_exists($item, 'has' . $columnName)) {
            $method = 'has' . $columnName;
            $value = $item->$method();
        } elseif (method_exists($item, 'is' . $columnName)) {
            $method = 'is' . $columnName;
            $value = $item->$method();
        } else {
            return '';
        }

        return $value;
    }

    public function renderValue($item, $columnName, $emptyValue = ' ', $parentField = null)
    {
        $value = $this->getValue($item, $columnName, $parentField);

        if (empty($value)) {
            return $emptyValue;
        }

        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }

        if ($value instanceof PersistentCollection) {
            $pieces = array();
            foreach ($value as $piece) {
                $pieces[] = $piece;
            }
            return implode(', ', $pieces);
        }

        return $value;
    }

    public function getRouteParams($item, $params)
    {
        $routeParams = array();

        foreach ($params as $param) {
            $routeParams[strtolower($param)] = $this->getValue($item, $param);
        }

        return $routeParams;
    }
}
