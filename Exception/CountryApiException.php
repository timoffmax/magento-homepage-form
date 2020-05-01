<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Exception;

use Magento\Framework\Exception\LocalizedException;

/**
 * Should be thrown when an error occurred in communicating with @link https://restcountries.eu/rest/v2
 */
class CountryApiException extends LocalizedException
{

}
