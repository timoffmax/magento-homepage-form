<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Block\Adminhtml\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Generic "Save" button
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Button config
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
