<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Service;

use GuzzleHttp\Psr7\Response;
use Magento\Framework\Serialize\SerializerInterface;
use Psr\Log\LoggerInterface;
use Timoffmax\HomepageForm\Api\Request\RequestInterface;

/**
 * Simplifies using custom loggers
 */
class ApiLogger
{
    /**
     * @var LoggerInterface
     */
    private $requestLogger;

    /**
     * @var LoggerInterface
     */
    private $responseLogger;

    /**
     * @var LoggerInterface
     */
    private $errorLogger;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * Logger constructor.
     * @param LoggerInterface $requestLogger
     * @param LoggerInterface $responseLogger
     * @param LoggerInterface $errorLogger
     * @param SerializerInterface $serializer
     */
    public function __construct(
        LoggerInterface $requestLogger,
        LoggerInterface $responseLogger,
        LoggerInterface $errorLogger,
        SerializerInterface $serializer
    ) {
        $this->requestLogger = $requestLogger;
        $this->responseLogger = $responseLogger;
        $this->errorLogger = $errorLogger;
        $this->serializer = $serializer;
    }

    /**
     * @param RequestInterface $requestObject
     */
    public function logRequest(RequestInterface $requestObject): void
    {
        $method = $requestObject->getMethod();
        $payload = $this->serializer->serialize($requestObject->getPayload());
        $endpoint = $requestObject->getEndpoint();

        $message = "{$method} request to endpoint '/{$endpoint}' sent. Request payload: {$payload}";
        $this->requestLogger->info($message);
    }

    /**
     * @param string $message
     */
    public function logResponse(RequestInterface $requestObject, Response $response): void
    {
        $endpoint = $requestObject->getEndpoint();
        $status = $response->getStatusCode();
        $body = $this->serializer->serialize($response->getBody());
        $message = "Request to endpoint '/{$endpoint}' finished with status {$status}. Body: {$body}";

        $this->responseLogger->info($message);
    }

    /**
     * @param string $message
     */
    public function logError(RequestInterface $requestObject, Response $response): void
    {
        $endpoint = $requestObject->getEndpoint();
        $status = $response->getStatusCode();
        $error = $response->getReasonPhrase();
        $message = "Request to endpoint '/{$endpoint}' failed with status {$status}. API error: {$error}";

        $this->errorLogger->error($message);
    }
}
