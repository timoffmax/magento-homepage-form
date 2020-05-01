<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\ViewModel;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Timoffmax\HomepageForm\Model\Config;
use Timoffmax\HomepageForm\Ui\Component\Option\Countries;

/**
 * HomepageForm view model
 */
class HomepageForm implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Countries
     */
    private $countriesList;

    /**
     * HomepageForm constructor.
     * @param Countries $countriesList
     * @param SerializerInterface $serializer
     * @param Config $config
     */
    public function __construct(
        Countries $countriesList,
        SerializerInterface $serializer,
        Config $config
    ) {
        $this->config = $config;
        $this->serializer = $serializer;
        $this->countriesList = $countriesList;
    }

    /**
     * @return string
     */
    public function getCountriesJson(): string
    {
        $countries = $this->countriesList->toOptionArray();
        $result = $this->serializer->serialize($countries);

        return $result;
    }
}
