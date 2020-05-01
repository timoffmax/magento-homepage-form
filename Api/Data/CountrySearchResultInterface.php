<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface CountrySearchResultInterface
 */
interface CountrySearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Timoffmax\HomepageForm\Api\Data\CountryInterface[]
     */
    public function getItems();

    /**
     * @param \Timoffmax\HomepageForm\Api\Data\CountryInterface[] $items
     * @return \Timoffmax\HomepageForm\Api\Data\CountrySearchResultInterface
     */
    public function setItems(array $items);
}
