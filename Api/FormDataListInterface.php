<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Timoffmax\HomepageForm\Api\Data\FormDataSearchResultInterface;

/**
 * Interface FormDataListInterface
 */
interface FormDataListInterface
{
    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Timoffmax\HomepageForm\Api\Data\FormDataSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): FormDataSearchResultInterface;
}
