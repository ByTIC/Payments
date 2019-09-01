<?php

namespace ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Traits;

use ByTIC\Payments\Gateways\Manager;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Fixtures\Records\PurchasableRecord;
use ByTIC\Payments\Tests\Fixtures\Records\PurchasableRecordManager;

/**
 * Class DetectFromHttpRequestTraitTest
 * @package ByTIC\Payments\Tests\Gateways\Providers\AbstractGateway\Traits
 */
class DetectFromHttpRequestTraitTest extends AbstractTest
{

    /**
     * @dataProvider dataGetRequestFromHttpRequest
     * @param $path
     * @param $requestClass
     * @throws \Exception
     */
    public function testGetRequestFromHttpRequest($path, $requestClass)
    {
        $httpRequest = $this->generateRequestFromFixtures(
            TEST_FIXTURE_PATH . '/requests/' . $path
        );

        $model = \Mockery::mock(PurchasableRecord::class)->makePartial();
        $model->shouldReceive('getPaymentGateway')->andReturn(null);

        $modelManager = \Mockery::mock(PurchasableRecordManager::class)->makePartial();
        $modelManager->shouldReceive('findOne')->andReturn($model);

        $request = Manager::getRequestFromHttpRequest($modelManager, null, $httpRequest);
        self::assertInstanceOf($requestClass, $request);
    }

    /**
     * @return array
     */
    public function dataGetRequestFromHttpRequest()
    {
        return [
            [
                '/librapay/completePurchaseParams.php',
                \ByTIC\Payments\Gateways\Providers\Librapay\Message\CompletePurchaseRequest::class,
            ],
            [
                '/librapay/completePurchaseParams2.php',
                \ByTIC\Payments\Gateways\Providers\Librapay\Message\CompletePurchaseRequest::class,
            ],
            [
                '/mobilpay/completePurchase/basicParams.php',
                \ByTIC\Payments\Gateways\Providers\Mobilpay\Message\CompletePurchaseRequest::class,
            ],
            [
                '/romcard/completePurchaseParams.php',
                \ByTIC\Payments\Gateways\Providers\Romcard\Message\CompletePurchaseRequest::class,
            ],
        ];
    }
}
