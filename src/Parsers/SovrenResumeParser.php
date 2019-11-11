<?php

namespace App\Components\ResumeParser\Parsers;

use App\Components\ResumeParser\ApiHelpers\SovrenApiHelper;
use App\Components\ResumeParser\Entities\Profile;
use App\Components\ResumeParser\EntityBag;
use App\Components\ResumeParser\Parsers\Processors\Sovren\EducationProcessor;
use App\Components\ResumeParser\Parsers\Processors\Sovren\ExperienceProcessor;
use App\Components\ResumeParser\Parsers\Processors\Sovren\ProfileProcessor;

/**
 * Class SovrenResumeParser
 * @package App\Components\ResumeParser\Parsers
 */
class SovrenResumeParser extends AbstractResumeParser
{

    /**
     * @inheritDoc
     */
    public function parse(string &$resumeBase64): EntityBag
    {
        $apiHelper = $this->getApiHelper();
        $parsedResume = $apiHelper->parseResume($resumeBase64);
        $parsedResume = __data_get($parsedResume, 'Value.ParsedDocument.Resume', []);

        return $this->prepareEntityBag($parsedResume);
    }

    /**
     * @inheritDoc
     */
    protected function getEducationEntities(array $resumeData): array
    {
        $educations = [];
        $resumeData = __data_get($resumeData, 'StructuredXMLResume.EducationHistory.SchoolOrInstitution', []);
        foreach ($resumeData as $education) {
            $processor = new EducationProcessor($education);
            $educations[] = $processor->process();
        }

        return $educations;
    }

    /**
     * @inheritDoc
     */
    protected function getExperienceEntities(array $resumeData): array
    {
        $experiences = [];
        $resumeData = __data_get($resumeData, 'StructuredXMLResume.EmploymentHistory.EmployerOrg', []);
        foreach ($resumeData as $experience) {
            $processor = new ExperienceProcessor($experience);
            $experiences[] = $processor->process();
        }

        return $experiences;
    }

    /**
     * @inheritDoc
     */
    protected function getProfileEntity(array $resumeData): Profile
    {
        $processor = new ProfileProcessor($resumeData);

        return $processor->process();
    }

    /**
     * @inheritDoc
     */
    protected function getApiHelperClass(): string
    {
        return SovrenApiHelper::class;
    }
}
