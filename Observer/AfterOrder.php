<?php
namespace Boostsales\Paymentfee\Observer;

use Magento\Framework\Event\ObserverInterface;

class AfterOrder implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $quote = $observer->getQuote();
        $paymentFee = $quote->getPaymentFee();
        $basePaymentFee = $quote->getBasePaymentFee();
        if (!$paymentFee || !$basePaymentFee) {
            return $this;
        }

        $order = $observer->getOrder();
        $order->setData('payment_fee', $paymentFee);
        $order->setData('base_payment_fee', $basePaymentFee);

        return $this;
    }
}
