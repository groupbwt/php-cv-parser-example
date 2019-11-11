<?php

namespace App\Components\ResumeParser\Parsers\Processors\Sovren;

use App\Components\Geocode\Location;
use App\Components\ResumeParser\Entities\AbstractEntity;
use App\Components\ResumeParser\Entities\Experience;
use App\Components\ResumeParser\Parsers\Processors\AbstractProcessor;
use App\Components\ResumeParser\Processors\Traits\HasDates;

/**
 * Class ExperienceProcessor
 * @package App\Components\ResumeParser\Parsers\Processors\Sovren
 */
class ExperienceProcessor extends AbstractProcessor
{
    use HasDates;

    /**
     * @return AbstractEntity
     */
    public function process(): AbstractEntity
    {
        $entity = new Experience();
        $position = $this->getLatestPosition();
        $positionLocation = $this->getPositionLocation($position);
        $companyName = $this->getCompanyName();
        $positionTitle = $this->getPositionTitle($position);
        $startDate = $this->getStartDate($position);
        $endDate = $this->getEndDate($position);
        $description = $this->getDescription($position);

        $entity->setCompanyName($companyName)
            ->setPositionTitle($positionTitle)
            ->setStartDate($startDate)
            ->setEndDate($endDate)
            ->setDescription($description)
            ->setLocation($positionLocation);

        return $entity;
    }

    /**
     * @param array $position
     *
     * @return string|null
     */
    private function getDescription(array &$position): ?string
    {
        return __data_get($position, 'Description');
    }

    /**
     * @return string|null
     */
    private function getCompanyName(): ?string
    {
        $companyName = data_get($this->data, 'UserArea.sov:EmployerOrgUserArea.sov:NormalizedEmployerOrgName');
        if (empty($companyName)) {
            $companyName = data_get($this->data, 'EmployerOrgName');
        }
        $companyName = trim($companyName);

        return !empty($companyName) ? $companyName : null;
    }

    /**
     * @return array
     */
    private function getLatestPosition(): array
    {
        return __data_get($this->data, 'PositionHistory.0', []);
    }

    /**
     * @param array $position
     *
     * @return array
     */
    private function getPositionLocation(array &$position): array
    {
        $location = __data_get($position, 'OrgInfo.0.PositionLocation', []);
        $location = new Location([
            'country_name' => __data_get($location, 'CountryCode'),
            'region_name'  => __data_get($location, 'Region.0'),
            'city_name'    => __data_get($location, 'Municipality'),
        ]);

        return $location->toArray();
    }

    /**
     * @param array $position
     *
     * @return string|null
     */
    private function getStartDate(array &$position): ?string
    {

        $date = __data_get($position, 'StartDate', []);

        return optional($this->getCarbonDate($date))->toDateString();
    }

    /**
     * @param array $position
     *
     * @return string|null
     */
    private function getEndDate(array &$position): ?string
    {
        $date = __data_get($position, 'EndDate', []);

        return optional($this->getCarbonDate($date))->toDateString();
    }

    /**
     * @param array $position
     *
     * @return string|null
     */
    private function getPositionTitle(array &$position): ?string
    {
        $positionTitle = __data_get($position, 'UserArea.sov:PositionHistoryUserArea.sov:NormalizedTitle');
        if (empty($positionTitle)) {
            $positionTitle = __data_get($position, 'Title');
        }
        $positionTitle = trim($positionTitle);

        return $positionTitle;
    }
}
