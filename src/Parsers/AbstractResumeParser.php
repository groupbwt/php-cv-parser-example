<?php

namespace App\Components\ResumeParser\Parsers;

use App\Components\ResumeParser\ApiHelpers\AbstractApiHelper;
use App\Components\ResumeParser\Entities\Profile;
use App\Components\ResumeParser\EntityBag;

/**
 * Class AbstractResumeParser
 * @package App\Components\ResumeParser\Parsers
 */
abstract class AbstractResumeParser
{
    /** @var AbstractApiHelper */
    private $apiHelper;

    /** @var int */
    private $userId;

    /** @var int */
    private $sessionId;

    /**
     * AbstractResumeParser constructor.
     *
     * @param int $userId
     * @param int $sessionId
     */
    public function __construct(int $userId, int $sessionId)
    {
        $this->apiHelper = $this->getApiHelper();
        $this->userId = $userId;
        $this->sessionId = $sessionId;
    }

    /**
     * @param string $resumeBase64
     *
     * @return EntityBag
     */
    abstract public function parse(string &$resumeBase64): EntityBag;

    /**
     * Returns array of \App\Components\ResumeParser\Entities\Education
     *
     * @param array $resumeData
     *
     * @return array
     */
    abstract protected function getEducationEntities(array $resumeData): array;

    /**
     * Returns array of \App\Components\ResumeParser\Entities\Experience
     *
     * @param array $resumeData
     *
     * @return array
     */
    abstract protected function getExperienceEntities(array $resumeData): array;

    /**
     * @param array $resumeData
     *
     * @return Profile
     */
    abstract protected function getProfileEntity(array $resumeData): Profile;

    /**
     * @return string
     */
    abstract protected function getApiHelperClass(): string;

    /**
     * @return AbstractApiHelper
     */
    protected function getApiHelper(): AbstractApiHelper
    {
        if (!isset($this->apiHelper)) {
            $this->apiHelper = app($this->getApiHelperClass());
        }

        return $this->apiHelper;
    }

    /**
     * @param array $resumeData
     *
     * @return EntityBag
     */
    protected function prepareEntityBag(array $resumeData): EntityBag
    {
        $profileEntity = $this->getProfileEntity($resumeData);
        $educationEntities = $this->getEducationEntities($resumeData);
        $experienceEntities = $this->getExperienceEntities($resumeData);
        $entityBag = new EntityBag();

        return $entityBag->setProfile($profileEntity)
            ->setEducations($educationEntities)
            ->setExperiences($experienceEntities);
    }
}
