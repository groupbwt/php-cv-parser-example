<?php

namespace App\Components\ResumeParser\Entities;

/**
 * Class Experience
 * @property string|null company_name
 * @property string|null position_title
 * @property string|null start_date
 * @property string|null end_date
 * @property string|null description
 * @property array|null job_levels
 * @property array|null location
 * @package App\Components\ResumeParser\Entities
 */
class Experience extends AbstractEntity
{
    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setCompanyName(?string $value)
    {
        $this->company_name = $value;

        return $this;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setPositionTitle(?string $value)
    {
        $this->position_title = $value;

        return $this;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setStartDate(?string $value)
    {
        $this->start_date = $value;

        return $this;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setEndDate(?string $value)
    {
        $this->end_date = $value;

        return $this;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setDescription(?string $value)
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param array|null $value
     *
     * @return $this
     */
    public function setJobLevels(?array $value)
    {
        $this->job_levels = $value;

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
