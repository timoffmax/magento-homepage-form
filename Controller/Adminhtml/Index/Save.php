<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Timoffmax\HomepageForm\Api\Data\FormDataInterface;
use Timoffmax\HomepageForm\Api\FormDataRepositoryInterface;
use Timoffmax\HomepageForm\Model\FormData;

/**
 * Saves request
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var string
     */
    public const ADMIN_RESOURCE = 'Timoffmax_HomepageForm::manage';

    /**
     * @var string
     */
    public const ROUTE = 'tom_hf/index/save';

    /**
     * @var FormDataRepositoryInterface
     */
    private $repository;

    /**
     * Save constructor.
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

        $saveAndContinue = $request->getParam('back');
        $requestId = $request->getPost(FormDataInterface::ID, null);

        if (null !== $requestId) {
            try {
                $formData = $request->getPost()->toArray();

                /** @var FormData $formDataRequest */
                $formDataRequest = $this->repository->getById((int)$requestId);
                $formDataRequest->setData($formData);

                $this->repository->save($formDataRequest);
                $this->messageManager->addSuccessMessage(__("Request {$requestId} has been saved successfully"));
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__("Request with ID {$requestId} not found"));
            } catch (CouldNotSaveException $e) {
                $this->messageManager->addErrorMessage(__("Can't save request {$requestId}"));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Request ID is not set'));
        }

        if (null !== $saveAndContinue && isset($formDataRequest)) {
            $resultRedirect->setPath('*/*/edit', ['id' => $formDataRequest->getId()]);
        } else {
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
