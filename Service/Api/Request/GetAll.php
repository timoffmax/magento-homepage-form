<?php
declare(strict_types=1);

namespace Timoffmax\HomepageForm\Service\Api\Request;

use Psr\Log\LoggerInterface;
use Timoffmax\HomepageForm\Exception\CountryApiException;
use Timoffmax\HomepageForm\Model\Request\AllCountriesRequest;
use Timoffmax\HomepageForm\Model\Request\AllCountriesRequestFactory;
use Timoffmax\HomepageForm\Service\Api\SendRequest;

/**
 * Service that sends @see AllCountriesRequest
 */
class GetAll
{
    /**
     * @var AllCountriesRequestFactory
     */
    private $requestFactory;

    /**
     * @var SendRequest
     */
    private $sendRequest;

    /**
     * @var LoggerInterface
     */
    private $logger;


    public function __construct(
        AllCountriesRequestFactory $requestFactory,
        SendRequest $sendRequest,
        LoggerInterface $logger
    ) {
        $this->requestFactory = $requestFactory;
        $this->sendRequest = $sendRequest;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function execute(): array
    {
        $result = [];

        /** @var AllCountriesRequest $requestObject */
        $requestObject = $this->requestFactory->create();

        try {
            $result = $this->sendRequest->execute($requestObject);
        } catch (CountryApiException $e) {
            $this->logger->error("Can't get list of countries. Error: {$e->getMessage()}");
        }

        return $result;
    }
}
