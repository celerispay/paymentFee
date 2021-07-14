<?php
namespace Boostsales\Paymentfee\Model\Creditmemo\Total;

use Magento\Sales\Model\Order\Creditmemo;
use Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal;
use Boostsales\Paymentfee\Helper\Data;

class Fee extends AbstractTotal
{

    protected $paymentHelper;

    public function __construct(
        Data $paymentHelper,
        array $data = []
    ) {
        parent::__construct($data);
        $this->paymentHelper = $paymentHelper;
    }

    public function collect(Creditmemo $creditmemo)
    {
        $creditmemo->setPaymentFee(0);
        $creditmemo->setBasePaymentFee(0);

        $storeId = $creditmemo->getOrder()->getStoreId();

        $order = $creditmemo->getOrder();
        $paymentFee = $order->getPaymentFee();
        $basePaymentFee = $order->getBasePaymentFee();

        if ($paymentFee != 0) {
            $creditmemo->setPaymentFee($paymentFee);
            $creditmemo->setBasePaymentFee($basePaymentFee);
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $paymentFee);
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $basePaymentFee);
            $creditmemo->setTaxAmount($creditmemo->getTaxAmount());
            $creditmemo->setBaseTaxAmount($creditmemo->getBaseTaxAmount());
        }

        return $this;
    }
}
