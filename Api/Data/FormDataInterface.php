<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Api\Data;

/**
 * Interface FormDataInterface
 */
interface FormDataInterface
{
    public const ID = 'id';
    public const NAME = 'name';
    public const PHONE = 'phone';
    public const EMAIL = 'email';
    public const IS_CHECKED = 'is_checked';
    public const ADDRESS = 'address';
    public const COUNTRY = 'country';

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $name
     * @return FormDataInterface
     */
    public function setName(string $name): FormDataInterface;

    /**
     * @return string|null
     */
    public function getPhone(): ?string;

    /**
     * @param string $phone
     * @return FormDataInterface
     */
    public function setPhone(string $phone): FormDataInterface;

    /**
     * @return bool
     */
    public function isChecked(): bool;

    /**
     * @param bool $isChecked
     * @return FormDataInterface
     */
    public function setIsChecked(bool $isChecked): FormDataInterface;

    /**
     * @return string|null
     */
    public function getAddress(): ?string;

    /**
     * @param string $address
     * @return FormDataInterface
     */
    public function setAddress(string $address): FormDataInterface;

    /**
     * @return string|null
     */
    public function getCountry(): ?string;

    /**
     * @param string $country
     * @return FormDataInterface
     */
    public function setCountry(string $country): FormDataInterface;
}
