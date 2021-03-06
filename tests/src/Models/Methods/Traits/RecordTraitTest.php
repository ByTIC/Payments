<?php

namespace ByTIC\Payments\Tests\Models\Methods\Traits;

use ByTIC\Payments\Gateways\Providers\Mobilpay\Gateway as MobilpayGateway;
use ByTIC\Payments\Gateways\Providers\Euplatesc\Gateway as EuplatescGateway;
use ByTIC\Payments\Models\Methods\Types\BankTransfer;
use ByTIC\Payments\Models\Methods\Types\Cash;
use ByTIC\Payments\Models\Methods\Types\CreditCards;
use ByTIC\Payments\Models\Methods\Types\Waiver;
use ByTIC\Payments\Tests\AbstractTest;
use ByTIC\Payments\Tests\Fixtures\Records\PaymentMethods\PaymentMethod;

/**
 * Class RecordTraitTest
 * @package ByTIC\Payments\Tests\Models\Methods\Traits
 */
class RecordTraitTest extends AbstractTest
{

    /**
     * @dataProvider data_getType
     *
     * @param $type
     * @param $class
     */
    public function test_getType($type, $class)
    {
        $method = new PaymentMethod();
        $method->type = $type;

        self::assertInstanceOf($class, $method->getType());
    }

    /**
     * @return array
     */
    public function data_getType()
    {
        return [
            ['bank-transfer', BankTransfer::class],
            ['cash', Cash::class],
            ['credit-cards', CreditCards::class],
            ['waiver', Waiver::class],
        ];
    }


    /**
     * @dataProvider data_getType_gateways
     *
     * @param $type
     * @param $class
     * @param $gateway
     */
    public function test_getType_gateways($type, $class, $gateway)
    {
        $method = new PaymentMethod();
        $method->type = $type;

        self::assertInstanceOf($class, $method->getType());
        self::assertSame($type, $method->getType()->getGatewayName());
    }

    /**
     * @return array
     */
    public function data_getType_gateways()
    {
        return [
            ['mobilpay', CreditCards::class, MobilpayGateway::class],
            ['euplatesc', CreditCards::class, EuplatescGateway::class]
        ];
    }
}
