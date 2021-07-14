<?php
namespace Boostsales\Paymentfee\Model\Calculation;

use Magento\Framework\Exception\ConfigurationMismatchException;
use Magento\Framework\ObjectManagerInterface;
use Boostsales\Paymentfee\Helper\Data as FeeHelper;
use Boostsales\Paymentfee\Model\Config\Source\PriceType;

class CalculatorFactory
{

    protected $helper;

    protected $objectManager;

    public function __construct(ObjectManagerInterface $objectManager, FeeHelper $helper)
    {
        $this->helper = $helper;
        $this->objectManager = $objectManager;
    }

    /**
     * @return Calculator\CalculatorInterface
     * @throws ConfigurationMismatchException
     */
    public function get()
    {
        return $this->objectManager->get(Calculator\FixedCalculator::class);
    }
}