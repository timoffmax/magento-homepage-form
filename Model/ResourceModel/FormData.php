<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Timoffmax\HomepageForm\Api\Data\FormDataInterface;

/**
 * FormData resource model
 */
class FormData extends AbstractDb
{
    /**
     * @var string
     */
    public const ENTITY_TABLE = 'tom_form_data';

    /**
     * @inheritDoc
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        $this->_init(static::ENTITY_TABLE, FormDataInterface::ID);
    }
}
