<?php

namespace Kristofvc\ListBundle\Builder;

class FilterBuilder
{
    protected $definedFilters = array();
    protected $extraParams = array();

    public function getExtraParams()
    {
        return $this->extraParams;
    }

    public function analyzeFilters($request, $configuration)
    {
        $query = $request->query;
        $definedFilters = array();
        foreach ($query as $key => $field) {
            foreach ($configuration->getFilterFields() as $name) {
                if (preg_match('%' . $name . '%', $key)) {
                    $tokens = explode($name, $key);
                    $definedFilters[$tokens[1]]['field'] = $tokens[0];
                    $definedFilters[$tokens[1]][$name] = $field;

                    $query->remove($key);
                }
            }
        }

        $this->extraParams = $query;
        $this->definedFilters = $definedFilters;
    }

    public function addFilters(&$qb, $configuration)
    {
        $index = 1;
        foreach ($configuration->getFilters() as $filter) {
            foreach ($this->definedFilters as $definedFilter) {
                if ($definedFilter['field'] == $filter->getField()) {
                    $data = array();
                    foreach ($filter->getDataFields() as $dataField) {
                        if (!is_null($definedFilter[$dataField])) {
                            $data[$dataField] = $definedFilter[$dataField];
                        }
                    }

                    $filter->addFilterToBuilder($qb, $index, $data);
                    $index++;
                }
            }
        }
    }
}
