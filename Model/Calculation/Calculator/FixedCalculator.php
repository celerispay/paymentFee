<?php



namespace Boostsales\Paymentfee\Model\Calculation\Calculator;

use Magento\Quote\Model\Quote;

class FixedCalculator extends AbstractCalculator
{
    /**
     * {@inheritdoc}
     */
    public function calculate(Quote $quote)
    {
        return $this->helper->getFee($quote);
    }
}
