<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Api\Request;

/**
 * Describes available Content-type header values
 */
interface ContentTypeInterface
{
    public const TYPE_NONE = null;
    public const TYPE_JSON = 'application/json';
    public const TYPE_FORM_URLENCODED = 'application/x-www-form-urlencoded';
}
