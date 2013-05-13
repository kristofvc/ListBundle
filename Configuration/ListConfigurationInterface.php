<?php

namespace Kristofvc\ListBundle\Configuration;

use Kristofvc\ListBundle\Model\Column;
use Kristofvc\ListBundle\Model\Action;
use Kristofvc\ListBundle\Model\Filter;
use Doctrine\ORM\QueryBuilder;

interface ListConfigurationInterface
{

    public function getColumns();

    public function addColumn(Column $column);

    public function getActions();

    public function addAction(Action $action);

    public function getFilters();

    public function addFilter(Filter $filter);

    public function getFilterFields();

    public function buildQuery(QueryBuilder &$qb);

    public function getDefaultParams();

    public function buildColumns();

    public function buildActions();

    public function buildFilters();

    public function getRepository();
}