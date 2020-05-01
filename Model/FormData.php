<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Timoffmax\HomepageForm\Model\ResourceModel\FormData as FormDataResource;
use Timoffmax\HomepageForm\Api\Data\FormDataInterface;

/**
 * FormData model
 */
class FormData extends AbstractModel implements IdentityInterface, FormDataInterface
{
    /**
     * @var string
     */
    protected const CACHE_TAG = FormDataResource::ENTITY_TABLE;

    /**
     * @inheritDoc
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @inheritDoc
     */
    protected $_idFieldName = FormDataInterface::ID;

    /**
     * @inheritDoc
     */
    protected $_eventPrefix = FormDataResource::ENTITY_TABLE;

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(FormDataResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        $value = $this->getData(FormDataInterface::NAME);;
        $result = (null !== $value) ? (int)$value : null;

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->getData(FormDataInterface::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): FormDataInterface
    {
        return $this->setData(FormDataInterface::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getPhone(): ?string
    {
        return $this->getData(FormDataInterface::PHONE);
    }

    /**
     * @inheritDoc
     */
    public function setPhone(string $phone): FormDataInterface
    {
        return $this->setData(FormDataInterface::PHONE, $phone);
    }

    /**
     * @inheritDoc
     */
    public function isChecked(): bool
    {
        return (bool)$this->getData(FormDataInterface::IS_CHECKED);
    }

    /**
     * @inheritDoc
     */
    public function setIsChecked(bool $isChecked): FormDataInterface
    {
        return $this->setData(FormDataInterface::IS_CHECKED, $isChecked);
    }

    /**
     * @inheritDoc
     */
    public function getAddress(): ?string
    {
        return $this->getData(FormDataInterface::ADDRESS);
    }

    /**
     * @inheritDoc
     */
    public function setAddress(string $address): FormDataInterface
    {
        return $this->setData(FormDataInterface::ADDRESS, $address);
    }

    /**
     * @inheritDoc
     */
    public function getCountry(): ?string
    {
        return $this->getData(FormDataInterface::COUNTRY);
    }

    /**
     * @inheritDoc
     */
    public function setCountry(string $country): FormDataInterface
    {
        return $this->setData(FormDataInterface::COUNTRY, $country);
    }
}
