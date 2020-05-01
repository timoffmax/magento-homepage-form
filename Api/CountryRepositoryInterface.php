<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Timoffmax\HomepageForm\Api\Data\CountryInterface;

/**
 * Interface CountryRepositoryInterface
 */
interface CountryRepositoryInterface
{
    /**
     * @param CountryInterface $item
     * @return CountryInterface
     * @throws CouldNotSaveException
     */
    public function save(CountryInterface $item): CountryInterface;

    /**
     * @param int $itemItemId
     * @return CountryInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $itemItemId): CountryInterface;

    /**
     * @param CountryInterface $item
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(CountryInterface $item): bool;

    /**
     * @param int $itemId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $itemId): bool;
}
