<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Timoffmax\HomepageForm\Api\Data\FormDataInterface;
use Timoffmax\HomepageForm\Api\FormDataRepositoryInterface;

/**
 * Deletes request
 */
class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @var string
     */
    public const ADMIN_RESOURCE = 'Timoffmax_HomepageForm::manage';

    /**
     * @var string
     */
    public const ROUTE = 'tom_hf/index/delete';

    /**
     * @var FormDataRepositoryInterface
     */
    private $repository;

    /**
     * Delete constructor.
     * @param Context $context
     * @param FormDataRepositoryInterface $repository
     */
    public function __construct(Context $context, FormDataRepositoryInterface $repository)
    {
        parent::__construct($context);

        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $request = $this->getRequest();
        $requestId = $request->getParam(FormDataInterface::ID, null);

        if (null !== $requestId) {
            try {
                $this->repository->deleteById((int)$requestId);
                $this->messageManager->addSuccessMessage(__('Request has successfully been deleted'));
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
            }
        } else {
            $this->messageManager->addErrorMessage(__('Request ID is not set'));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
