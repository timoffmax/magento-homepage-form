<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Service;

use Psr\Log\LoggerInterface;
use Timoffmax\HomepageForm\Api\CountryListInterface;
use Timoffmax\HomepageForm\Api\CountryRepositoryInterface;
use Timoffmax\HomepageForm\Api\Data\CountryInterface;
use Timoffmax\HomepageForm\Api\Data\CountryInterfaceFactory;
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
     * @var CountryRepositoryInterface
     */
    private $countryRepository;

    /**
     * @var CountryListInterface
     */
    private $countryList;

    /**
     * @var CountryInterfaceFactory
     */
    private $countryFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * GetCountriesList constructor.
     * @param CountryInterfaceFactory $countryFactory
     * @param CountryRepositoryInterface $countryRepository
     * @param CountryListInterface $countryList
     * @param LoggerInterface $logger
     * @param GetAll $getCountries
     */
    public function __construct(
        CountryInterfaceFactory $countryFactory,
        CountryRepositoryInterface $countryRepository,
        CountryListInterface $countryList,
        LoggerInterface $logger,
        GetAll $getCountries
    ) {
        $this->getCountries = $getCountries;
        $this->countryRepository = $countryRepository;
        $this->countryList = $countryList;
        $this->countryFactory = $countryFactory;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function execute(): array
    {
        $result = $this->getFromRepository();

        if (empty($result)) {
            $result = $this->getFromApi();
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getFromApi(): array
    {
        $result = [];

        $allCountries = $this->getCountries->execute();

        foreach ($allCountries as $country) {
            $name = $country[static::COUNTRY_FIELD_NAME] ?? '';
            $code = $country[static::COUNTRY_FIELD_ALPHA_2_CODE] ?? '';
            $this->saveToRepository($name, $code);

            $result[$code] = $name;
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getFromRepository(): array
    {
        $result = [];

        $allCountries = $this->countryList->getList();

        foreach ($allCountries->getItems() as $country) {
            $name = $country->getName();
            $code = $country->getCode();

            $result[$code] = $name;
        }

        return $result;
    }

    /**
     * @param string $name
     * @param string $code
     */
    private function saveToRepository(string $name, string $code): void
    {
        /** @var CountryInterface $country */
        $country = $this->countryFactory->create();
        $country->setName($name);
        $country->setCode($code);

        try {
            $this->countryRepository->save($country);
        } catch (\Throwable $t) {
            $message = "Can't create country with params: name = {$name}, code = {$code}. Details: {$t->getMessage()}";
            $this->logger->error($message);
        }
    }
}
