<?php

namespace App\Components\ResumeParser\Entities;

use ArrayAccess;
use ReflectionClass;
use ReflectionException;

/**
 * Class AbstractEntity
 * @package App\Components\ResumeParser\Entities
 */
abstract class AbstractEntity implements ArrayAccess
{
    /** @var array $data */
    protected $data = [];

    /**
     * @return string
     * @throws ReflectionException
     */
    public function getType(): string
    {
        $className = with(new ReflectionClass($this))->getShortName();
        $className = snake_case($className);

        return $className;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return json_encode($this->data);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->data[$offset] = $value;
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        if (array_key_exists($offset, $this->data)) {
            return $this->data[$offset];
        }

        return null;
    }

    /**
     * @param mixed $name
     * @param mixed $value
     */
    public function __set($name, $value): void
    {
        $this->offsetSet($name, $value);
    }

    /**
     * @param mixed $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @param mixed $name
     *
     * @return bool
     */
    public function __isset($name): bool
    {
        return $this->offsetExists($name);
    }
}
