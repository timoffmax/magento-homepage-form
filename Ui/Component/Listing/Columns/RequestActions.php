<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Timoffmax\HomepageForm\Controller\Adminhtml\Index\Delete;
use Timoffmax\HomepageForm\Controller\Adminhtml\Index\Edit;

/**
 * Request grid action column
 */
class RequestActions extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * RequestActions constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);

        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $confirmationMessage = __('Are you sure you want to delete this request?');

            foreach ($dataSource['data']['items'] as &$item) {
                $deleteUrl = $this->urlBuilder->getUrl(Delete::ROUTE, ['id' => $item['id']]);

                $item[$this->getData('name')]['edit'] = [
                    'href' => $this->urlBuilder->getUrl(Edit::ROUTE, ['id' => $item['id']]),
                    'label' => __('Edit'),
                    'hidden' => false,
                ];
                $item[$this->getData('name')]['delete'] = [
                    'on_click' => "deleteConfirm('{$confirmationMessage}', '{$deleteUrl}')",
                    'label' => __('Delete'),
                    'confirm' => [
                        'title' => __('Delete request "${ $.$data.id }"'),
                        'message' => __('Are you sure you want to delete request "${ $.$data.id }"?')
                    ],
                    'href' => $deleteUrl,
                    'hidden' => false,
                    'post' => true,
                ];
            }
        }

        return $dataSource;
    }
}
