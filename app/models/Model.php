<?php

namespace app\models;

use system\DataBase;
use system\GorestRestApi;

abstract class Model
{
    protected static string $tableName;
    protected static array $columns;
    protected static int $perPage = 10;
//    protected static array $availableSources = ['database' => DataBase::class, 'gorest_rest_api' => GorestRestApi::class];

    public function getTableName(): string
    {
        return static::$tableName;
    }

    public function getColumns(): array
    {
        return static::$columns;
    }

    public function setLimitPerPage($perPage): object
    {
        static::$perPage = $perPage;
        return $this;
    }

    public function all($data, $dataSource)
    {

        $data['per_page'] = static::$perPage;
        if ($dataSource === 'database') {
            $data['table_name'] = $this->getTableName();
            return DataBase::all($data);
        }
        if ($dataSource === 'gorest_rest_api') {
            return GorestRestApi::all($data);
        }
    }

    public  function find($id, $dataSource)
    {
        $data['id'] = $id;
        if ($dataSource === 'database') {
            $data['table_name'] = $this->getTableName();
            return DataBase::find($data);
        }
        if ($dataSource === 'gorest_rest_api') {
            return GorestRestApi::find($data);
        }
    }

    public  function insert($data, $dataSource)
    {
        if ($dataSource === 'database') {
            $data['table_name'] = $this->getTableName();
            return DataBase::insert($data);
        }
        if ($dataSource === 'gorest_rest_api') {
            return GorestRestApi::insert($data);
        }
    }

    public  function update($data, $dataSource)
    {
        if ($dataSource === 'database') {
            $data['table_name'] = $this->getTableName();
            return DataBase::update($data);
        }
        if ($dataSource === 'gorest_rest_api') {
            return GorestRestApi::update($data);
        }
    }

    public  function delete($id, $dataSource)
    {
        $data['id'] = $id;
        if ($dataSource === 'database') {
            $data['table_name'] = $this->getTableName();
            return DataBase::delete($data);
        }
        if ($dataSource === 'gorest_rest_api') {
            return GorestRestApi::delete($data);
        }
    }
}



