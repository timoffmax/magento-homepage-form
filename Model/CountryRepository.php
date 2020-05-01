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
use Timoffmax\HomepageForm\Api\CountryListInterface;
use Timoffmax\HomepageForm\Api\CountryRepositoryInterface;
use Timoffmax\HomepageForm\Api\Data\CountryInterface;
use Timoffmax\HomepageForm\Api\Data\CountryInterfaceFactory;
use Timoffmax\HomepageForm\Api\Data\CountrySearchResultInterface;
use Timoffmax\HomepageForm\Api\Data\CountrySearchResultInterfaceFactory;
use Timoffmax\HomepageForm\Model\ResourceModel\Country as CountryResource;
use Timoffmax\HomepageForm\Model\ResourceModel\Country\Collection;
use Timoffmax\HomepageForm\Model\ResourceModel\Country\CollectionFactory;

/**
 * Country model repository
 */
class CountryRepository implements CountryRepositoryInterface, CountryListInterface
{
    /**
     * @var CountryInterfaceFactory
     */
    private $factory;

    /**
     * @var CountrySearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var CountryResource
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
     * CountryRepository constructor.
     * @param CountryInterfaceFactory $factory
     * @param CountrySearchResultInterfaceFactory $searchResultFactory
     * @param CountryResource $resourceModel
     * @param CollectionFactory $collectionFactory
     * @param SearchCriteriaBuilderFactory $criteriaBuilderFactory
     * @param CollectionProcessor $collectionProcessor
     */
    public function __construct(
        CountryInterfaceFactory $factory,
        CountrySearchResultInterfaceFactory $searchResultFactory,
        CountryResource $resourceModel,
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
    public function save(CountryInterface $item): CountryInterface
    {
        try {
            /** @var CountryInterface $item */
            $this->resourceModel->save($item);
        } catch (\Throwable $t) {
            throw new CouldNotSaveException(__($t->getMessage()));
        }

        return $item;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $itemId): CountryInterface
    {
        /** @var CountryInterface $item */
        $item = $this->factory->create();
        $this->resourceModel->load($item, $itemId);

        if (!$item->getId()) {
            throw NoSuchEntityException::singleField(CountryInterface::ID, $itemId);
        }

        return $item;
    }

    /**
     * @inheritDoc
     */
    public function delete(CountryInterface $item): bool
    {
        try {
            /** @var CountryInterface $item */
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
    public function getList(SearchCriteriaInterface $searchCriteria = null): CountrySearchResultInterface
    {
        /** @var CountrySearchResultInterface $searchResults */
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
