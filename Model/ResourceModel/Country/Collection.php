<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model\ResourceModel\Country;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Timoffmax\HomepageForm\Api\Data\CountryInterface;
use Timoffmax\HomepageForm\Model\Country;
use Timoffmax\HomepageForm\Model\ResourceModel\Country as CountryResource;

/**
 * Country model collection
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = CountryInterface::ID;

    /**
     * @var string
     */
    protected $_eventPrefix = CountryResource::ENTITY_TABLE . '_collection';

    /**
     * @var string
     */
    protected $_eventObject = CountryResource::ENTITY_TABLE . '_collection';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(Country::class, CountryResource::class);
    }
}
