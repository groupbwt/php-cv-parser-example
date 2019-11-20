<?php

namespace App\Components\ResumeParser\Parsers\Processors\Sovren;

use App\Components\Geocode\Location;
use App\Components\ResumeParser\Entities\AbstractEntity;
use App\Components\ResumeParser\Entities\Profile;
use App\Components\ResumeParser\Parsers\Processors\AbstractProcessor;
use App\Models\System\Language;

/**
 * Class ProfileProcessor
 * @package App\Components\ResumeParser\Parsers\Processors\Sovren
 */
class ProfileProcessor extends AbstractProcessor
{

    /**
     * @return Profile
     */
    public function process(): AbstractEntity
    {
        $entity = new Profile();
        $firstName = $this->getFirstName();
        $lastName = $this->getLastName();
        $phone = $this->getPhone();
        $languages = $this->getLanguages(__data_get($this->data, 'StructuredXMLResume.Languages.Language', []));
        $location = $this->getLocation(__data_get($this->data, 'StructuredXMLResume.ContactInfo.ContactMethod', []));

        $entity->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPhone($phone)
            ->setLanguages($languages)
            ->setLocation($location);

        return $entity;
    }

    /**
     * @return string
     */
    private function getFirstName(): string
    {
        $name = data_get($this->data, 'StructuredXMLResume.ContactInfo.PersonName.GivenName');

        return $name;
    }

    /**
     * @return string
     */
    private function getLastName(): string
    {
        $name = data_get($this->data, 'StructuredXMLResume.ContactInfo.PersonName.FamilyName');

        return $name;
    }

    /**
     * @return string|null
     */
    private function getPhone(): ?string
    {
        $phone = __data_get($this->data, 'UserArea.sov:ResumeUserArea.sov:ReservedData.sov:Phones.sov:Phone');

        return $phone;
    }

    /**
     * @param array|null $languages
     *
     * @return array
     */
    private function getLanguages(?array $languages): array
    {
        if (empty($languages)) {
            return [];
        }
        $codes = array_unique($languages);

        return Language::query()
            ->whereIn('iso_639_1_code', $codes)
            ->get()
            ->toArray();
    }

    /**
     * @param array|null $data
     *
     * @return array
     */
    private function getLocation(?array $data): array
    {
        if (empty($data)) {
            return [];
        }
        $location = new Location([
            'country_name' => data_get($data, 'CountryCode'),
            'region_name'  => data_get($data, 'Region.0'),
            'city_name'    => data_get($data, 'Municipality'),
            'raw_address'  => data_get($data, 'DeliveryAddress.AddressLine.0'),
        ]);

        return $location->toArray();
    }

}
