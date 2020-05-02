<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Service\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Serialize\SerializerInterface;
use Timoffmax\HomepageForm\Api\Request\RequestInterface;
use Timoffmax\HomepageForm\Exception\CountryApiException;
use Timoffmax\HomepageForm\Model\Config;
use Timoffmax\HomepageForm\Service\ApiLogger;

/**
 * Unified API request sender
 */
class SendRequest
{
    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ApiLogger
     */
    private $logger;

    /**
     * SendRequest constructor.
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     * @param SerializerInterface $serializer
     * @param ApiLogger $logger
     * @param Config $config
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        SerializerInterface $serializer,
        ApiLogger $logger,
        Config $config
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->config = $config;
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * @param RequestInterface $requestObject
     * @return array
     */
    public function execute(RequestInterface $requestObject): array
    {
        $response = $this->sendRequest($requestObject);
        $result = $this->processResponse($response);

        return $result;
    }

    /**
     * @param RequestInterface $requestObject
     * @return Response
     */
    private function sendRequest(RequestInterface $requestObject): Response
    {
        $client = $this->getClient();

        try {
            $this->logger->logRequest($requestObject);

            $response = $client->request(
                $requestObject->getMethod(),
                $requestObject->getEndpoint(),
                $requestObject->getOptions()
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);

            $this->logger->logError($requestObject, $response);
        }

        $this->logger->logResponse($requestObject, $response);

        return $response;
    }

    /**
     * @param Response $response
     * @return array
     */
    private function processResponse(Response $response): array
    {
        $isSuccess = in_array($response->getStatusCode(), [200, 201]);

        if (true === $isSuccess) {
            $result = $this->processSuccess($response);
        } else {
            $this->processError($response);
        }

        return $result;
    }

    /**
     * @param Response $response
     * @return array
     */
    private function processSuccess(Response $response): array
    {
        $result = $this->serializer->unserialize($response->getBody()) ?? [];

        return $result;
    }

    /**
     * @param Response $response
     * @throws CountryApiException
     */
    private function processError(Response $response): void
    {
        $message = "Request failed with status code {$response->getStatusCode()}. ";
        $message .= "Details: {$response->getReasonPhrase()}.";

        throw new CountryApiException(__($message));
    }

    /**
     * Sets up the client object and returns it
     *
     * @return Client
     */
    private function getClient(): Client
    {
        /** @var Client $client */
        $client = $this->clientFactory->create(
            [
                'config' => [
                    'base_uri' => $this->config->getCountryApi()
                ]
            ]
        );

        return $client;
    }
}
