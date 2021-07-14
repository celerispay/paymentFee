<?php
namespace Boostsales\Paymentfee\Model\Total;

use Magento\Quote\Model\Quote\Address\Total;
use Boostsales\Paymentfee\Model\Calculation\Calculator\CalculatorInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Boostsales\Paymentfee\Helper\Data as FeeHelper;
use Magento\Tax\Model\Calculation;

class Fee extends Address\Total\AbstractTotal
{
    protected $calculator;

    protected $helper;
    
    private $taxCalculator;

    public function __construct(
        CalculatorInterface $calculator,
        FeeHelper $helper,
        Calculation $taxCalculator
    ) {
        $this->calculator = $calculator;
        $this->helper = $helper;
        $this->taxCalculator = $taxCalculator;
    }

    /**
     * @param Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return $this
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $total->setTotalAmount($this->getCode(), 0);
        $total->setBaseTotalAmount($this->getCode(), 0);

        if (!count($shippingAssignment->getItems())) {
            return $this;
        }

        $baseFee = 0;
        $fee = 0;   
        $baseFee = $this->calculator->calculate($quote);
        $fee = $this->helper->getStoreFee($baseFee, $quote);

        $total->setTotalAmount($this->getCode(), $fee);
        $total->setBaseTotalAmount($this->getCode(), $baseFee);

        $total->setPaymentFee($fee);
        $total->setBasePaymentFee($baseFee);

        $quote->setPaymentFee($fee);
        $quote->setBasePaymentFee($baseFee);

        return $this;
    }

    /**
     * @param Quote $quote
     * @param Total $total
     * @return array
     */
    public function fetch(Quote $quote, Total $total)
    {
        $fee = $total->getPaymentFee();
        $address = $this->getAddressFromQuote($quote);

        $result = [
            [
                'code' => $this->getCode(),
                'title' => __("Administration Fee"),
                'value' => $fee
            ]
        ];

        return $result;
    }

    /**
     * @param Quote $quote
     * @return Address
     */
    private function getAddressFromQuote(Quote $quote)
    {
        return $quote->isVirtual() ? $quote->getBillingAddress() : $quote->getShippingAddress();
    }

    /**
     * Get label
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __("Administration Fee");
    }
}
