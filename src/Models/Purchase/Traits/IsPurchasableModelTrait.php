<?php

namespace ByTIC\Payments\Models\Purchase\Traits;

use ByTIC\Common\Payments\Gateways\Providers\AbstractGateway\Message\PurchaseRequest;
use ByTIC\Common\Payments\Gateways\Providers\AbstractGateway\Message\RedirectResponse\RedirectTrait;
use ByTIC\Common\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecord;
use ByTIC\Common\Payments\Models\BillingRecord\Traits\RecordTrait as BillingRecordTrait;
use ByTIC\Common\Payments\Models\Methods\Traits\RecordTrait;
use ByTIC\Common\Records\Records;
use Exception;

/**
 * Class MethodTrait
 * @package ByTIC\Payments\Traits
 *
 * @property int $id
 * @property string $status_notes
 * @property string $received
 * @property string $created
 *
 * @method string getConfirmURL
 * @method string getIpnURL
 * @method Records getManager
 */
trait IsPurchasableModelTrait
{
    use IsPurchasableTrait {
        getPurchaseParameters as getPurchaseParametersAbstract;
    }

    /**
     * @return PurchaseRequest|RedirectTrait
     */
    public function getPurchaseRequest()
    {
        return $this->getPaymentMethod()->getGateway()->purchaseFromModel($this);
    }

    /**
     * @return RecordTrait
     */
    abstract public function getPaymentMethod();

    /**
     * @param $note
     */
    public function saveGatewayNote($note)
    {
        $this->setGatewayNotes($note);
        $this->update();
    }

    /**
     * @param $note
     */
    public function setGatewayNotes($note)
    {
        $this->status_notes = $note;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getPurchaseParametersCard()
    {
        $params = null;
        $billing = $this->getPurchaseBillingRecord();
        if ($billing) {
            if (!in_array(BillingRecordTrait::class, class_uses($billing))) {
                throw new Exception(
                    sprintf(
                        'Billing record in %s must use BillingRecordTrait %s',
                        $this->getClassName(),
                        BillingRecordTrait::class
                    )
                );
            }
            $params = [];
            $params['firstName'] = $billing->getFirstName();
            $params['lastName'] = $billing->getLastName();
            $params['email'] = $billing->getEmail();
            $params['phone'] = $billing->getPurchasePhone();
            $params['city'] = $billing->getPurchaseCity();
            $params['country'] = $billing->getPurchaseCountry();
        }

        return $params;
    }

    /**
     * @return BillingRecord|null
     */
    public function getPurchaseBillingRecord()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getConfirmStatusTitle()
    {
        return $this->getManager()->getMessage('confirm.' . $this->getStatus()->getName());
    }
}
