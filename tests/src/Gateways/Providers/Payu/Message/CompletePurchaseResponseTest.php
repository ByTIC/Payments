<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\Payu\Message;

use ByTIC\Payments\Gateways\Providers\Payu\Message\CompletePurchaseResponse;
use ByTIC\Payments\Gateways\Providers\Payu\Message\CompletePurchaseRequest;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Message\CompletePurchaseResponseTestTrait;
use Symfony\Component\HttpFoundation\Request;

class CompletePurchaseResponseTest extends AbstractTest
{
    use CompletePurchaseResponseTestTrait;

    protected function getNewResponse()
    {
        $request = new CompletePurchaseRequest($this->client, new Request());

        return new CompletePurchaseResponse($request, []);
    }
}
