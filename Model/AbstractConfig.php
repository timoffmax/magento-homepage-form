<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Abstract config provider
 *
 * Usually this model should be places in Core/Base vendor module (Timoffmax_Base)
 * but it was placed here for simplicity
 */
abstract class AbstractConfig
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param SerializerInterface $serializer
     */
    public function __construct(ScopeConfigInterface $scopeConfig, SerializerInterface $serializer)
    {
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    /**
     * @param int|null $storeId
     * @return bool
     */
    abstract public function isEnabled(int $storeId = null): bool;

    /**
     * Get config value for current store
     *
     * @param string $path
     * @param int|null $storeId
     * @return mixed
     */
    protected function getStoreConfigValue(string $path, int $storeId = null)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Returns config flag value
     *
     * @param string $path
     * @param int|null $storeId
     * @return bool
     *
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    protected function getStoreConfigFlag(string $path, int $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Helper to simply get multiselect selected values as array
     *
     * @param string $path
     * @param int|null $storeId
     * @return array
     */
    protected function getMultiselectValue(string $path, int $storeId = null): array
    {
        $result = [];
        $value = $this->getStoreConfigValue($path, $storeId);

        if (null !== $value) {
            $result = explode(',', $value);
        }

        return  $result;
    }

    /**
     * Helper to simplify getting serialized values as an array
     *
     * @param string $path
     * @param int|null $storeId
     * @return array
     */
    protected function getSerializedValue(string $path, int $storeId = null): array
    {
        $jsonValue = $this->getStoreConfigValue($path, $storeId);

        try {
            $result = $this->serializer->unserialize($jsonValue);

            if (false === is_array($result)) {
                $result = [];
            }
        } catch (\Throwable $t) {
            $result = [];
        }

        return $result;
    }
}
