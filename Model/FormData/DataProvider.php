<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model\FormData;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Timoffmax\HomepageForm\Model\FormData;
use Timoffmax\HomepageForm\Model\ResourceModel\FormData\Collection;
use Timoffmax\HomepageForm\Model\ResourceModel\FormData\CollectionFactory;

/**
 * FormData model data provider
 * @see FormData
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    private $loadedData;

    /**
     * DataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();

        foreach ($items as $contact) {
            $this->loadedData[$contact->getId()] = $contact->getData();
        }

        return $this->loadedData;
    }
}
