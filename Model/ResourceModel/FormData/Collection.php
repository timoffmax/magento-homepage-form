<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model\ResourceModel\FormData;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Timoffmax\HomepageForm\Api\Data\FormDataInterface;
use Timoffmax\HomepageForm\Model\FormData;
use Timoffmax\HomepageForm\Model\ResourceModel\FormData as FormDataResource;

/**
 * Form data model collection
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = FormDataInterface::ID;

    /**
     * @var string
     */
    protected $_eventPrefix = FormDataResource::ENTITY_TABLE . '_collection';

    /**
     * @var string
     */
    protected $_eventObject = FormDataResource::ENTITY_TABLE . '_collection';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(FormData::class, FormDataResource::class);
    }
}
