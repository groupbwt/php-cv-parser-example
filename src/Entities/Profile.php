<?php

namespace App\Components\ResumeParser\Entities;

/**
 * Class Profile
 * @property string|null first_name
 * @property string|null last_name
 * @property string|null phone
 * @property array|null languages
 * @property array|null location
 * @package App\Components\ResumeParser\Entities
 */
class Profile extends AbstractEntity
{
    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setFirstName(?string $value)
    {
        $this->first_name = $value;

        return $this;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setLastName(?string $value)
    {
        $this->last_name = $value;

        return $this;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setPhone(?string $value)
    {
        $this->phone = $value;

        return $this;
    }

    /**
     * @param array|null $value
     *
     * @return $this
     */
    public function setLanguages(?array $value)
    {
        $this->languages = $value;

        return $this;
    }

    /**
     * @param array|null $value
     *
     * @return $this
     */
    public function setLocation(?array $value)
    {
        $this->location = $value;

        return $this;
    }
}
