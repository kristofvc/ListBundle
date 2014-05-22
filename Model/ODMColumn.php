<?php

namespace Kristofvc\ListBundle\Model;

class ODMColumn extends Column
{
    public function __construct($name, $columnHeader, $params = array())
    {
        parent::__construct($name, $columnHeader, $params);

        if (isset($params['sortField']) && !is_null($params['sortField'])) {
            $this->sortField = $params['sortField'];
        } else {
            $this->sortField = lcfirst($this->name);
        }
    }
}
