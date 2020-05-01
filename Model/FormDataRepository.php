<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Timoffmax\HomepageForm\Api\Data\FormDataInterface;
use Timoffmax\HomepageForm\Api\Data\FormDataInterfaceFactory;
use Timoffmax\HomepageForm\Api\Data\FormDataSearchResultInterface;
use Timoffmax\HomepageForm\Api\Data\FormDataSearchResultInterfaceFactory;
use Timoffmax\HomepageForm\Api\FormDataListInterface;
use Timoffmax\HomepageForm\Api\FormDataRepositoryInterface;
use Timoffmax\HomepageForm\Model\ResourceModel\FormData as FormDataResource;
use Timoffmax\HomepageForm\Model\ResourceModel\FormData\Collection;
use Timoffmax\HomepageForm\Model\ResourceModel\FormData\CollectionFactory;

/**
 * Form data model repository
 */
class FormDataRepository implements FormDataRepositoryInterface, FormDataListInterface
{
    /**
     * @var FormDataInterfaceFactory
     */
    private $factory;

    /**
     * @var FormDataSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var FormDataResource
     */
    private $resourceModel;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $criteriaBuilderFactory;

    /**
     * @var CollectionProcessor
     */
    private $collectionProcessor;

    /**
     * FormDataRepository constructor.
     * @param FormDataInterfaceFactory $factory
     * @param FormDataSearchResultInterfaceFactory $searchResultFactory
     * @param FormDataResource $resourceModel
     * @param CollectionFactory $collectionFactory
     * @param SearchCriteriaBuilderFactory $criteriaBuilderFactory
     * @param CollectionProcessor $collectionProcessor
     */
    public function __construct(
        FormDataInterfaceFactory $factory,
        FormDataSearchResultInterfaceFactory $searchResultFactory,
        FormDataResource $resourceModel,
        CollectionFactory $collectionFactory,
        SearchCriteriaBuilderFactory $criteriaBuilderFactory,
        CollectionProcessor $collectionProcessor
    ) {
        $this->factory = $factory;
        $this->searchResultFactory = $searchResultFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->criteriaBuilderFactory = $criteriaBuilderFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(FormDataInterface $item): FormDataInterface
    {
        try {
            /** @var FormDataInterface $item */
            $this->resourceModel->save($item);
        } catch (\Throwable $t) {
            throw new CouldNotSaveException(__($t->getMessage()));
        }

        return $item;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): FormDataInterface
    {
        /** @var FormDataInterface $item */
        $item = $this->factory->create();
        $this->resourceModel->load($item, $id);

        if (!$item->getId()) {
            throw NoSuchEntityException::singleField(FormDataInterface::ID, $id);
        }

        return $item;
    }

    /**
     * @inheritDoc
     */
    public function delete(FormDataInterface $item): bool
    {
        try {
            /** @var FormDataInterface $item */
            $this->resourceModel->delete($item);
        } catch (\Throwable $t) {
            throw new CouldNotDeleteException(__($t->getMessage()));
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $itemId): bool
    {
        return $this->delete($this->getById($itemId));
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): FormDataSearchResultInterface
    {
        /** @var FormDataSearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        if ($searchCriteria === null) {
            /** @var SearchCriteriaBuilder $criteriaBuilder */
            $criteriaBuilder = $this->criteriaBuilderFactory->create();
            $searchCriteria = $criteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $items = $collection->getItems();
        $searchResults->setItems($items);
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
