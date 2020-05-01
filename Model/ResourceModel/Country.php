<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Timoffmax\HomepageForm\Api\Data\CountryInterface;

/**
 * Country resource model
 */
class Country extends AbstractDb
{
    /**
     * @var string
     */
    public const ENTITY_TABLE = 'tom_country';

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init(static::ENTITY_TABLE, CountryInterface::ID);
    }
}
