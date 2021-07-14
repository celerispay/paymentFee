<?php



namespace Boostsales\Paymentfee\Model\Calculation\Calculator;

use Magento\Quote\Model\Quote;

interface CalculatorInterface
{
    public function calculate(Quote $quote);
}
