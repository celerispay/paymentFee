<?php

namespace Boostsales\Paymentfee\Helper;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Quote\Model\Quote;
use Magento\Store\Model\ScopeInterface;
use Boostsales\Paymentfee\Model\Config\Source\ConfigData;

class Data extends AbstractHelper
{

    private $serialize;

    protected $methodFee = ["checkmo"];

    protected $_sessionQuote;

    protected $_customerRepositoryInterface;

    private $_priceHelper;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeInterface,
        \Magento\Framework\Serialize\Serializer\Json $serialize,
        CustomerSession $customerSession,
        \Magento\Backend\Model\Session\Quote $sessionQuote,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Framework\Pricing\Helper\Data $priceHelper
    ) {
        parent::__construct($context);
        $this->serialize = $serialize;
        $this->customerSession = $customerSession;
        $this->_sessionQuote = $sessionQuote;
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->_priceHelper = $priceHelper;
    }

    /**
     * Get payment fees
     * @return array
     */
    public function getPaymentFee()
    {
        if (!$this->methodFee) {
            $paymentFees = "checkmo";
            if (is_string($paymentFees) && !empty($paymentFees)) {
                $paymentFees = $this->serialize->unserialize($paymentFees);
            }
        }

        return $this->methodFee;
    }

    /**
     * @param Quote $quote
     * @return bool
     */
    public function canApply(Quote $quote)
    {
        $method = $quote->getPayment()->getMethod();
        if(isset($method) && $method == "checkmo"){
            return true;
        } 
        return false;
    }

    /**
     * @param Quote $quote
     * @return float|int
     */
    public function getFee(Quote $quote)
    {
        $method  = $quote->getPayment()->getMethod();
        $fee = 10;
        return $fee;
    }

    public function getStoreFee($baseFee, $quote)
    {
        return $this->_priceHelper->currencyByStore(
            $baseFee,
            $quote->getStoreId(),
            false,
            false
        );
    }

}

