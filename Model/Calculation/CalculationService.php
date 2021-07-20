<?php



namespace Boostsales\Paymentfee\Model\Calculation;

use Magento\Framework\Exception\ConfigurationMismatchException;
use Magento\Quote\Model\Quote;
use Boostsales\Paymentfee\Helper\Data as FeeHelper;
use Boostsales\Paymentfee\Model\Calculation\Calculator\CalculatorInterface;
use Psr\Log\LoggerInterface;

class CalculationService implements CalculatorInterface
{
    protected $factory;

    protected $helper;

    protected $logger;

    public function __construct(CalculatorFactory $factory, FeeHelper $helper, LoggerInterface $logger)
    {
        $this->factory = $factory;
        $this->helper = $helper;
        $this->logger = $logger;
    }

    public function calculate(Quote $quote)
    {
        if (!$this->helper->canApply($quote)) {
            return 0;
        }

        if ($this->hasMaxOrderTotal($quote)) {
            return 0;
        }
        
        try {
            return $this->factory->get()->calculate($quote);
        } catch (ConfigurationMismatchException $e) {
            $this->logger->error($e);
            return 0.0;
        }
    }

    private function hasMaxOrderTotal(Quote $quote)
    {
        $amount = $quote->getBaseSubtotal(); 
        return  $amount > 250 ? true: false;
    }

}
