<?php
namespace Boostsales\Paymentfee\Model\Pdf;

use Magento\Sales\Model\Order\Pdf\Total\DefaultTotal;
use Magento\Tax\Helper\Data;
use Magento\Tax\Model\Calculation;
use Magento\Tax\Model\ResourceModel\Sales\Order\Tax\CollectionFactory;
use Boostsales\Paymentfee\Helper\Data as FeeHelper;

class Fee extends DefaultTotal
{
    protected $helper;

    public function __construct(
        Data $taxHelper,
        Calculation $taxCalculation,
        CollectionFactory $ordersFactory,
        FeeHelper $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct(
            $taxHelper,
            $taxCalculation,
            $ordersFactory,
            $data
        );
    }

    public function getTotalsForDisplay()
    {
        $totals = [];
        $paymentFee = $this->getSource()->getPaymentFee();
        if ($paymentFee != 0) {
            $paymentFeeTax = $this->getSource()->getPaymentFeeTax();
            $amount = $this->getOrder()->formatPriceTxt($paymentFee);
            $amountInclTax = $this->getOrder()->formatPriceTxt($paymentFee + $paymentFeeTax);
            $defaultLabel = __("Administration Fee");
            $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;
            $totals[] = [
                'amount' => $this->getAmountPrefix() . $amount,
                'label' => $defaultLabel . ':',
                'font_size' => $fontSize
            ];
        }

        return $totals;
    }
}
