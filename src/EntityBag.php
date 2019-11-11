<?php

namespace App\Components\ResumeParser;

use App\Components\ResumeParser\Entities\Education;
use App\Components\ResumeParser\Entities\Profile;
use App\Components\ResumeParser\Entities\Experience;
use RuntimeException;

/**
 * Class EntityBag
 * @package App\Components\ResumeParser
 */
class EntityBag
{
    /**
     * @var Profile $profile
     */
    private $profile;

    /**
     * @var array $educations
     */
    private $educations;

    /**
     * @var array $experiences
     */
    private $experiences;

    public function __construct()
    {
        $this->setEducations([]);
        $this->setExperiences([]);
        $this->setProfile(new Profile());
    }

    /**
     * @param Profile|null $profile
     *
     * @return EntityBag
     */
    public function setProfile(?Profile $profile): EntityBag
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @param array $localEntities
     * @param array $entities
     * @param string $entityClass
     */
    private function setEntities(array &$localEntities, array $entities, string $entityClass)
    {
        foreach ($entities as $entity) {
            $entityObj = app($entityClass);
            if ($entity instanceof $entityObj) {
                $localEntities[] = $entity;
            } else {
                throw new RuntimeException('All entity items must be instance of ' . $entityClass);
            }
        }
    }

    /**
     * @param array $educations
     *
     * @return EntityBag
     */
    public function setEducations(array $educations): EntityBag
    {
        $this->setEntities($this->educations, $educations, Education::class);

        return $this;
    }

    /**
     * @param array $experiences
     *
     * @return EntityBag
     */
    public function setExperiences(array $experiences): EntityBag
    {
        $this->setEntities($this->experiences, $experiences, Experience::class);

        return $this;
    }

    /**
     * @return Profile
     */
    public function getProfile(): Profile
    {
        return $this->profile;
    }

    /**
     * @return array
     */
    public function getEducations(): array
    {
        return $this->educations;
    }

    /**
     * @return array
     */
    public function getExperiences(): array
    {
        return $this->experiences;
    }
}
