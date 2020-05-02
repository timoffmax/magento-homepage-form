<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\ViewModel;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Timoffmax\HomepageForm\Controller\Index\SaveAction;
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
     * @var UrlInterface
     */
    private $url;

    /**
     * HomepageForm constructor.
     * @param Countries $countriesList
     * @param SerializerInterface $serializer
     * @param UrlInterface $url
     * @param Config $config
     */
    public function __construct(
        Countries $countriesList,
        SerializerInterface $serializer,
        UrlInterface $url,
        Config $config
    ) {
        $this->config = $config;
        $this->serializer = $serializer;
        $this->countriesList = $countriesList;
        $this->url = $url;
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

    /**
     * Is used in JS layout helper
     * view/frontend/layout/cms_index_index.xml
     *
     * @return string
     */
    public function getFormUrl(): string
    {
        $result = $this->url->getUrl(SaveAction::ROUTE);

        return $result;
    }
}
