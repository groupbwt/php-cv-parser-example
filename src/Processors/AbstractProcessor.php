<?php

namespace App\Components\ResumeParser\Parsers\Processors;

use App\Components\ResumeParser\Entities\AbstractEntity;

/**
 * Class AbstractProcessor
 * @package App\Components\ResumeParser\Parsers\Processors
 */
abstract class AbstractProcessor
{
    /**
     * @var array
     */
    protected $data;

    /**
     * AbstractProcessor constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->setData($data);
    }

    /**
     * @return AbstractEntity
     */
    abstract public function process(): AbstractEntity;

    /**
     * @param array $data
     *
     * @return AbstractProcessor
     */
    public function setData(array $data): AbstractProcessor
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
