<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Model\Request;

use Magento\Framework\Webapi\Rest\Request;
use Timoffmax\HomepageForm\Api\Request\RequestInterface;
use Timoffmax\HomepageForm\Api\Request\ContentTypeInterface;
use Timoffmax\HomepageForm\Model\Config;

/**
 * Abstract request to @link https://restcountries.eu
 */
abstract class AbstractRequest implements RequestInterface
{
    public const ENDPOINT = '/';
    public const METHOD = Request::HTTP_METHOD_GET;
    public const CONTENT_TYPE = ContentTypeInterface::TYPE_JSON;

    /**
     * @var Config
     */
    private $config;

    /**
     * AbstractRequest constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function getMethod(): string
    {
        return static::METHOD;
    }

    /**
     * @inheritDoc
     */
    public function getEndpoint(): string
    {
        return static::ENDPOINT;
    }

    /**
     * Merges options
     * You don't need to rewrite this method in most cases
     *
     * @inheritDoc
     */
    public function getOptions(): array
    {
        $result = [];

        $result = array_merge($result, $this->getHeaders());
        $result = array_merge($result, $this->getPayload());

        return $result;
    }

    /**
     * Payload contains auth parameters by default
     *
     * @inheritDoc
     */
    public function getPayload(): array
    {
        return [];
    }

    /**
     * Most commonly required headers
     *
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        $result = [];
        $headers = [
            'Accept' => ContentTypeInterface::TYPE_JSON,
        ];

        if (null !== static::CONTENT_TYPE) {
            $headers['Content-Type'] = static::CONTENT_TYPE;
        }

        $result['headers'] = $headers;

        return $result;
    }
}
