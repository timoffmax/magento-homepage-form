<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Api\Data;

/**
 * Interface CountryInterface
 */
interface CountryInterface
{
    public const ID = 'id';
    public const CODE = 'code';
    public const NAME = 'name';

    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @return string|null
     */
    public function getCode(): ?string;

    /**
     * @param string $code
     * @return CountryInterface
     */
    public function setCode(string $code): CountryInterface;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string $name
     * @return CountryInterface
     */
    public function setName(string $name): CountryInterface;
}
