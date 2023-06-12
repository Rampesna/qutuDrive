<?php

namespace App\Services\JqxGrid;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JqxGridService
{
    private $tableName;

    private $columns;

    private $request;

    public function __construct(
        string  $tableName,
        array   $columns,
        Request $request
    )
    {
        $this->tableName = $tableName;
        $this->columns = $columns;
        $this->request = $request;
    }

    public function jqxGrid()
    {
        $pagenum = $this->request->pagenum;
        $pagesize = $this->request->pagesize;
        $start = $pagenum * $pagesize;

        $filterscount = $this->request->filterscount ?? 0;
        $conditions = [];

        for ($i = 0; $i < $filterscount; $i++) {
            $filtervalue = $this->request->input("filtervalue{$i}");
            $filtercondition = $this->request->input("filtercondition{$i}");
            $filterdatafield = $this->request->input("filterdatafield{$i}");
            $filteroperator = $this->request->input("filteroperator{$i}");

            $condition = '';
            $value = '';

            switch ($filtercondition) {
                case 'CONTAINS':
                    $condition = 'like';
                    $value = "%{$filtervalue}%";
                    break;
                case 'DOES_NOT_CONTAIN':
                    $condition = 'not like';
                    $value = "%{$filtervalue}%";
                    break;
                case 'EQUAL':
                    $condition = '=';
                    $value = $filtervalue;
                    break;
                case 'NOT_EQUAL':
                    $condition = '<>';
                    $value = $filtervalue;
                    break;
                case 'GREATER_THAN':
                    $condition = '>';
                    $value = $filtervalue;
                    break;
                case 'LESS_THAN':
                    $condition = '<';
                    $value = $filtervalue;
                    break;
                case 'GREATER_THAN_OR_EQUAL':
                    $condition = '>=';
                    $value = $filtervalue;
                    break;
                case 'LESS_THAN_OR_EQUAL':
                    $condition = '<=';
                    $value = $filtervalue;
                    break;
                case 'STARTS_WITH':
                    $condition = 'like';
                    $value = "{$filtervalue}%";
                    break;
                case 'ENDS_WITH':
                    $condition = 'like';
                    $value = "%{$filtervalue}";
                    break;
                case 'NULL':
                    $condition = 'is null';
                    break;
                case 'NOT_NULL':
                    $condition = 'is not null';
                    break;
            }

            $conditions[] = [
                'column' => $filterdatafield,
                'operator' => $condition,
                'value' => $value,
                'boolean' => ($i > 0) ? $filteroperator === 0 ? 'and' : 'or' : '',
            ];
        }

        $query = DB::table($this->tableName)->select($this->columns);

        foreach ($conditions as $condition) {
            $query->where($condition['column'], $condition['operator'], $condition['value'], $condition['boolean']);
        }

        $totalRows = $query->count();
        $companies = $query->skip($start)->take($pagesize)->get();

        return [
            'TotalRows' => $totalRows,
            'Rows' => $companies,
        ];
    }
}
