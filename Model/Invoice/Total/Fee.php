<?php
namespace Boostsales\Paymentfee\Model\Invoice\Total;

use Magento\Sales\Model\Order\Invoice;
use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

class Fee extends AbstractTotal
{

    public function collect(Invoice $invoice)
    {
        $invoice->setPaymentFee(0);
        $invoice->setBasePaymentFee(0);
        $order = $invoice->getOrder();

        if ($order->getInvoiceCollection()->getTotalCount()) {
            return $this;
        }

        $paymentFee = $order->getPaymentFee();
        $basePaymentFee = $order->getBasePaymentFee();

        if ($paymentFee != 0) {
            $invoice->setPaymentFee($paymentFee);
            $invoice->setBasePaymentFee($basePaymentFee);
            $invoice->setGrandTotal($invoice->getGrandTotal() + $paymentFee);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $basePaymentFee);
            $invoice->setTaxAmount($invoice->getTaxAmount());
            $invoice->setBaseTaxAmount($invoice->getBaseTaxAmount());
        }

        return $this;
    }
}
