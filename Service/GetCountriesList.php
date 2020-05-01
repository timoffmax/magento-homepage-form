<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Service;

use Timoffmax\HomepageForm\Service\Api\Request\GetAll;

/**
 * Returns list of countries as an array
 * [alpha2Code => name]
 */
class GetCountriesList
{
    public const COUNTRY_FIELD_NAME = 'name';
    public const COUNTRY_FIELD_ALPHA_2_CODE = 'alpha2Code';

    /**
     * @var GetAll
     */
    private $getCountries;

    /**
     * GetCountriesList constructor.
     * @param GetAll $getCountries
     */
    public function __construct(GetAll $getCountries)
    {
        $this->getCountries = $getCountries;
    }

    /**
     * @return array
     */
    public function execute(): array
    {
        $result = [];

        $allCountries = $this->getCountries->execute();

        foreach ($allCountries as $country) {
            $name = $country[static::COUNTRY_FIELD_NAME] ?? '';
            $code = $country[static::COUNTRY_FIELD_ALPHA_2_CODE] ?? '';

            $result[$code] = $name;
        }

        return $result;
    }
}
