<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This file contains a user story for listing beers
 */
final class BeerContext implements Context
{
    private string $baseUrl;
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->baseUrl = "http://localhost:8000";
    }

    /**
     * @When sending a request to :path
     */
    public function sendingARequestTo(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create($this->baseUrl . $path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }
        assert($this->response->getStatusCode() === 200);
    }

    /**
     * @Then I should see the in the detail the identifier :arg1
     */
    public function iShouldSeeTheText($arg1)
    {
        $requestContentWithoutTags = strip_tags($this->response->getContent());
        if (!str_contains($requestContentWithoutTags, $arg1)) {
            throw new \RuntimeException("Cannot find expected text '$arg1'");

        }
    }
}
