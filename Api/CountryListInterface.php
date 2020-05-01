<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Timoffmax\HomepageForm\Api\Data\CountrySearchResultInterface;

/**
 * Interface CountryListInterface
 */
interface CountryListInterface
{
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Timoffmax\HomepageForm\Api\Data\CountrySearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): CountrySearchResultInterface;
}
