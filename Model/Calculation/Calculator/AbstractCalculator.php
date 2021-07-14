<?php



namespace Boostsales\Paymentfee\Model\Calculation\Calculator;

use Boostsales\Paymentfee\Helper\Data as FeeHelper;

abstract class AbstractCalculator implements CalculatorInterface
{
    protected $helper;
    public function __construct(FeeHelper $helper)
    {
        $this->helper = $helper;
    }
}
