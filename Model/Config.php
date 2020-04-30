<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model;

/**
 * Provides access to the module config values
 */
class Config extends AbstractConfig
{
    /**
     * Config paths
     */
    private const XML_PATH_GENERAL_ENABLED = 'timoffmax_homepage_form/general/enabled';

    /**
     * @inheritDoc
     */
    public function isEnabled(int $storeId = null): bool
    {
        $result = $this->getStoreConfigFlag(self::XML_PATH_GENERAL_ENABLED, $storeId);

        return $result;
    }
}
