<?php

namespace App\Modules\Users\Requests;


use App\Modules\Shared\Requests\BaseRequest;

class ListAllUsersRequest extends BaseRequest
{
    public function getFilters()
    {
        return [];
    }

    public function constructQueryCriteria(array $queryParameters)
    {
        $filters = $this->setFilters(data_get($queryParameters, 'filters'));
        return array_merge($this->constructBaseGetQuery($queryParameters), ['filters' => $filters]);
    }
}
