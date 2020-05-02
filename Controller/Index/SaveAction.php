<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Exception\LocalizedException;
use Timoffmax\HomepageForm\Api\Data\FormDataInterface;
use Timoffmax\HomepageForm\Api\Data\FormDataInterfaceFactory;
use Timoffmax\HomepageForm\Api\FormDataRepositoryInterface;
use Timoffmax\HomepageForm\Model\FormData;

/**
 * Saves submitted form data
 */
class SaveAction extends Action implements HttpPostActionInterface, CsrfAwareActionInterface
{
    /**
     * @var string
     */
    public const ROUTE = 'tom_hf/index/saveAction';

    /**
     * Expected form
     *
     * @var string
     */
    public const FORM_NAME = 'timoffmax-homepage-form';

    /**
     * Expected form fields
     *
     * @var array
     */
    public const FORM_FIELDS = [
        FormDataInterface::NAME,
        FormDataInterface::PHONE,
        FormDataInterface::IS_CHECKED,
        FormDataInterface::EMAIL,
        FormDataInterface::ADDRESS,
        FormDataInterface::COUNTRY,
    ];

    /**
     * @var array
     */
    private $validationErrors = [];

    /**
     * @var Validator
     */
    private $formKeyValidator;

    /**
     * @var FormDataInterfaceFactory
     */
    private $formDataFactory;

    /**
     * @var FormDataRepositoryInterface
     */
    private $formDataRepository;

    /**
     * SaveAction constructor.
     * @param Validator $formKeyValidator
     * @param FormDataInterfaceFactory $formDataFactory
     * @param FormDataRepositoryInterface $formDataRepository
     * @param Context $context
     */
    public function __construct(
        Validator $formKeyValidator,
        FormDataInterfaceFactory $formDataFactory,
        FormDataRepositoryInterface $formDataRepository,
        Context $context
    ) {
        parent::__construct($context);

        $this->formKeyValidator = $formKeyValidator;
        $this->formDataRepository = $formDataRepository;
        $this->formDataFactory = $formDataFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $error = false;
        $message = null;

        if (true === $this->validateRequest()) {
            $request = $this->getRequest();
            $formData = $request->getPost(static::FORM_NAME, []);
            $isChecked = $this->stringToBool($formData[FormDataInterface::IS_CHECKED]);

            /** @var FormData $formDataItem */
            $formDataItem = $this->formDataFactory->create();
            $formDataItem->setData($formData);
            $formDataItem->setIsChecked($isChecked);

            try {
                $this->formDataRepository->save($formDataItem);
                $message = __('Yay! Your request was processed.');
            } catch (LocalizedException $e) {
                $error = true;
                $message = $e->getMessage();
            }
        } else {
            $error = true;
            $message = array_shift($this->validationErrors);
        }

        $responseData = [
            'error' => $error,
            'message' => $message,
        ];

        return $result->setData($responseData);
    }

    /**
     * @return bool
     */
    private function validateRequest(): bool
    {
        $result = true;
        $request = $this->getRequest();
        $formData = $request->getPost(static::FORM_NAME, []);

        if (!$this->formKeyValidator->validate($request)) {
            $result = false;
            $this->validationErrors[] = __('Form key is invalid. Try to refresh the page.');
        }

        foreach (static::FORM_FIELDS as $fieldName) {
            $fieldNotEmpty = !empty($formData[$fieldName]);
            $result = $result && $fieldNotEmpty;

            if (false === $fieldNotEmpty) {
                $this->validationErrors[] = __("Field '{$fieldName}' is not set.");
            }
        }

        return $result;
    }

    /**
     * @param string $value
     * @return bool
     */
    private function stringToBool(string $value): bool
    {
        $result = $value === "true" ? true : false;

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}
