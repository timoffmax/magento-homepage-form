<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Displays edit request form
 */
class Edit extends Action implements HttpGetActionInterface
{
    /**
     * @var string
     */
    public const ADMIN_RESOURCE = 'Timoffmax_HomepageForm::manage';

    /**
     * @var string
     */
    public const ROUTE = 'tom_hf/index/edit';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * Edit constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Homepage Form Request'));

        return $resultPage;
    }
}
