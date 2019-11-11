<?php

namespace App\Components\ResumeParser\Parsers\Processors\Sovren;

use App\Components\ResumeParser\Entities\AbstractEntity;
use App\Components\ResumeParser\Entities\Education;
use App\Components\ResumeParser\Parsers\Processors\AbstractProcessor;
use App\Components\ResumeParser\Processors\Traits\HasDates;
use App\Models\Education\Major;

/**
 * Class EducationProcessor
 * @package App\Components\ResumeParser\Parsers\Processors\Sovren
 */
class EducationProcessor extends AbstractProcessor
{

    use HasDates;

    /**
     * @return AbstractEntity
     */
    public function process(): AbstractEntity
    {
        $entity = new Education();
        $latestDegree = $this->getLatestDegree();
        $educationType = $this->getEducationType();
        $institutionName = $this->getInstitutionName();
        $startDate = $this->getStartDate($latestDegree);
        $gradDate = $this->getGradDate($latestDegree);
        $degreeType = $this->getDegreeType($latestDegree);
        $majors = $this->getMajors($latestDegree);

        $entity->setEducationType($educationType)
            ->setInstitutionName($institutionName)
            ->setStartDate($startDate)
            ->setGradDate($gradDate)
            ->setDegreeType($degreeType)
            ->setMajors($majors);

        return $entity;
    }

    /**
     * @return string|null
     */
    private function getInstitutionName(): ?string
    {
        $institutionName = data_get($this->data, 'UserArea.sov:SchoolOrInstitutionTypeUserArea.sov:NormalizedSchoolName');
        if (empty($institutionName)) {
            $institutionName = data_get($this->data, 'School.0.SchoolName');
        }
        $institutionName = trim($institutionName);

        return !empty($institutionName) ? $institutionName : null;
    }

    /**
     * @return array
     */
    private function getLatestDegree(): array
    {
        return __data_get($this->data, 'Degree.0', []);
    }

    /**
     * @param array $degree
     *
     * @return string|null
     */
    private function getStartDate(array &$degree): ?string
    {

        $date = __data_get($degree, 'DatesOfAttendance.0.StartDate', []);

        return optional($this->getCarbonDate($date))->toDateString();
    }

    /**
     * @param array $degree
     *
     * @return string|null
     */
    private function getGradDate(array &$degree): ?string
    {
        $date = __data_get($degree, 'DatesOfAttendance.0.EndDate', []);

        return optional($this->getCarbonDate($date))->toDateString();
    }

    /**
     * @return array|null
     */
    private function getEducationType(): ?array
    {
        $type = __data_get($this->data, '@schoolType');

        return $type;
    }

    /**
     * @param array $degree
     *
     * @return string|null
     */
    private function getDegreeType(array &$degree): ?string
    {
        $type = __data_get($degree, '@degreeType');

        return $type;
    }

    /**
     * @param array $degree
     *
     * @return array
     */
    private function getMajors(array &$degree): array
    {
        $preparedMajors = [];
        $majors = __data_get($degree, 'DegreeMajor', []);
        foreach ($majors as $item) {
            $majors = __data_get($item, 'Name', []);
            $preparedMajors = array_merge($preparedMajors, $majors);
        }
        $preparedMajors = array_unique($preparedMajors);
        $preparedMajors = Major::query()
            ->whereIn('name', $preparedMajors)
            ->get(['id', 'title'])
            ->toArray();

        return $preparedMajors;
    }
}
