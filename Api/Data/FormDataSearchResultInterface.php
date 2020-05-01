<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface FormDataSearchResultInterface
 */
interface FormDataSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Timoffmax\HomepageForm\Api\Data\FormDataInterface[]
     */
    public function getItems();

    /**
     * @param \Timoffmax\HomepageForm\Api\Data\FormDataInterface[] $items
     * @return \Timoffmax\HomepageForm\Api\Data\FormDataSearchResultInterface
     */
    public function setItems(array $items);
}
