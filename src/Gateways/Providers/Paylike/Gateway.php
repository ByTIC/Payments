<?php

namespace ByTIC\Payments\Gateways\Providers\Paylike;

use ByTIC\Omnipay\Paylike\Gateway as AbstractGateway;
use ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;

/**
 * Class Gateway
 * @package ByTIC\Payments\Gateways\Providers\Paylike
 */
class Gateway extends AbstractGateway
{
    use GatewayTrait;

    /**
     * @inheritDoc
     */
    public function setSandbox($value)
    {
        return $this->setTestMode($value == 'yes');
    }

    /**
     * @inheritDoc
     */
    public function getSandbox()
    {
        return $this->getTestMode() === true ? 'yes' : 'no';
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        if (strlen($this->getPublicKey()) >= 5 && strlen($this->getPrivateKey()) > 5) {
            return true;
        }

        return false;
    }
}
