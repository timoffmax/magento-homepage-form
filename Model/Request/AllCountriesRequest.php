<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model\Request;

use Timoffmax\HomepageForm\Api\Request\ContentTypeInterface;
use Timoffmax\HomepageForm\Api\Request\RequestInterface;

/**
 * Model of request that returns list of all the countries
 */
class AllCountriesRequest extends AbstractRequest implements RequestInterface
{
    public const ENDPOINT = 'all';
    public const CONTENT_TYPE = ContentTypeInterface::TYPE_NONE;
}
