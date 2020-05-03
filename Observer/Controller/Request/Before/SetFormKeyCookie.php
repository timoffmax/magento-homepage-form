<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Observer\Controller\Request\Before;

use Magento\Framework\App\PageCache\FormKey as CacheFormKey;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Session\Config\ConfigInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;

/**
 * Sets "form_key" cookie if it's empty
 */
class SetFormKeyCookie implements ObserverInterface
{
    /**
     * @var FormKey
     */
    private $formKey;

    /**
     * @var CacheFormKey
     */
    private $cookieFormKey;

    /**
     * @var CookieMetadataFactory
     */
    private $cookieMetadataFactory;

    /**
     * @var ConfigInterface
     */
    private $sessionConfig;

    /**
     * FixEmptyFormKeyCookie constructor.
     * @param FormKey $formKey
     * @param CacheFormKey $cookieFormKey
     * @param CookieMetadataFactory $cookieMetadataFactory
     * @param ConfigInterface $sessionConfig
     */
    public function __construct(
        FormKey $formKey,
        CacheFormKey $cookieFormKey,
        CookieMetadataFactory $cookieMetadataFactory,
        ConfigInterface $sessionConfig
    ) {
        $this->formKey = $formKey;
        $this->cookieFormKey = $cookieFormKey;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->sessionConfig = $sessionConfig;
    }

    /**
     * @param Observer $observer
     * @throws LocalizedException
     */
    public function execute(Observer $observer): void
    {
        if (empty($this->cookieFormKey->get())) {
            $this->setFormKeyCookie();
        }
    }

    /**
     * @throws LocalizedException
     */
    private function setFormKeyCookie(): void
    {
        $cookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata();
        $cookieMetadata->setDomain($this->sessionConfig->getCookieDomain());
        $cookieMetadata->setPath($this->sessionConfig->getCookiePath());
        $cookieMetadata->setSecure($this->sessionConfig->getCookieSecure());
        $lifetime = $this->sessionConfig->getCookieLifetime();

        if ($lifetime !== 0) {
            $cookieMetadata->setDuration($lifetime);
        }

        $formKey = $this->formKey->getFormKey();

        $this->formKey->set($formKey);
        $this->cookieFormKey->set(
            $formKey,
            $cookieMetadata
        );
    }
}
