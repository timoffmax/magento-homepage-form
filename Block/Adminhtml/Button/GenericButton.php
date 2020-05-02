<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Block\Adminhtml\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;

/**
 * Generic button
 */
class GenericButton
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * GenericButton constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * Generates url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
