<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Timoffmax\HomepageForm\Api\Data\FormDataInterface;

/**
 * Interface FormDataRepositoryInterface
 */
interface FormDataRepositoryInterface
{
    /**
     * @param FormDataInterface $formDataItem
     * @return FormDataInterface
     * @throws CouldNotSaveException
     */
    public function save(FormDataInterface $formDataItem): FormDataInterface;

    /**
     * @param int $id
     * @return FormDataInterface
     * @throws NoSuchEntityException
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function getById(int $id): FormDataInterface;

    /**
     * @param FormDataInterface $formDataItem
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(FormDataInterface $formDataItem): bool;

    /**
     * @param int $itemId
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function deleteById(int $itemId): bool;
}
