<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Ui\Component\Option;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Timoffmax\HomepageForm\Service\GetCountriesList;

/**
 * Provides list of countries
 */
class Countries implements OptionSourceInterface, ArgumentInterface
{
    /**
     * @var GetCountriesList
     */
    private $getCountriesList;

    /**
     * Countries constructor.
     * @param GetCountriesList $getCountriesList
     */
    public function __construct(GetCountriesList $getCountriesList)
    {
        $this->getCountriesList = $getCountriesList;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $result = [];

        try {
            $countries = $this->getCountriesList->execute();

            foreach ($countries as $key => $name) {
                $result[] = [
                    'value' => $key,
                    'label' => $name,
                ];
            }
        } catch (\Throwable $t) {
            $result = [];
        }

        return $result;
    }
}
