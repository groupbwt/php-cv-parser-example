<?php

namespace App\Components\ResumeParser\Entities;

/**
 * Class Education
 * @property array|null education_type
 * @property string|null institution_name
 * @property array|null institution
 * @property string|null start_date
 * @property string|null grad_date
 * @property string|null degree_type
 * @property array|mixed majors
 * @package App\Components\ResumeParser\Entities
 */
class Education extends AbstractEntity
{
    /**
     * @param array|null $value
     *
     * @return $this
     */
    public function setEducationType(?array $value)
    {
        $this->education_type = $value;

        return $this;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setInstitutionName(?string $value)
    {
        $this->institution_name = $value;

        return $this;
    }

    /**
     * @param array|null $value
     *
     * @return $this
     */
    public function setInstitution(?array $value)
    {
        $this->institution = $value;

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
    public function setGradDate(?string $value)
    {
        $this->grad_date = $value;

        return $this;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setDegreeType(?string $value)
    {
        $this->degree_type = $value;

        return $this;
    }

    /**
     * @param array $value
     *
     * @return $this
     */
    public function setMajors(array $value)
    {
        $this->majors = $value;

        return $this;
    }
}
