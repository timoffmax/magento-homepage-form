<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Timoffmax\HomepageForm\Api\Data\CountryInterface;
use Timoffmax\HomepageForm\Model\ResourceModel\Country as CountryResource;

/**
 * Country model
 */
class Country extends AbstractModel implements IdentityInterface, CountryInterface
{
    /**
     * @var string
     */
    protected const CACHE_TAG = CountryResource::ENTITY_TABLE;

    /**
     * @inheritDoc
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @inheritDoc
     */
    protected $_idFieldName = CountryInterface::ID;

    /**
     * @inheritDoc
     */
    protected $_eventPrefix = CountryResource::ENTITY_TABLE;

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(CountryResource::class);
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
        $value = $this->getData(CountryInterface::ID);;
        $result = (null !== $value) ? (int)$value : null;

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->getData(CountryInterface::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): CountryInterface
    {
        return $this->setData(CountryInterface::NAME, $name);
    }

    /**
     * @inheritDoc
     */
    public function getCode(): ?string
    {
        return $this->getData(CountryInterface::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setCode(string $code): CountryInterface
    {
        return $this->setData(CountryInterface::CODE, $code);
    }
}
