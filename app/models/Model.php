<?php

namespace app\models;

use system\DataBase;

abstract class Model
{
    protected static string $tableName;
    protected static array $columns;
    protected static int $limit_per_page = 10;
    protected static array $availableSources = ['database', 'api'];

    public function getTableName(): string
    {
        return static::$tableName;
    }

    public function getColumns(): array
    {
        return static::$columns;
    }

    public function setLimitPerPage($limit_per_page): object
    {
        static::$limit_per_page = $limit_per_page;
        return $this;
    }

    public function all($params)
    {
        $params['limit_per_page'] = static::$limit_per_page;
        return DataBase::all($this, $params);
    }

    public  function find($id)
    {
        return DataBase::find($this, $id);
    }

    public  function insert($data)
    {
        return DataBase::insert($this, $data);
    }

    public  function update($data)
    {
        return DataBase::update($this, $data);
    }

    public  function delete($id)
    {
        return DataBase::delete($this, $id);
    }
}



