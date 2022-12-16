<?php

namespace system;

class Request
{
    private ?int $id;
    private array $params;
    private array $postData;
    private string $dataSource;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams($params): void
    {
        $this->params = $params;
    }

    public function getPostData(): array
    {
        return $this->postData;
    }

    public function setPostData($postData): void
    {
        $this->postData = $postData;
    }

    public function getDataSource(): string
    {
        return $this->dataSource;
    }

    public function setDataSource($dataSource): void
    {
        $this->dataSource = $dataSource;
    }
}