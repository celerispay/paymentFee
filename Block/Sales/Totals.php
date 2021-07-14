<?php
namespace Boostsales\Paymentfee\Block\Sales;

use Magento\Framework\DataObjectFactory;
use Magento\Framework\View\Element\Template;
use Boostsales\Paymentfee\Helper\Data;

class Totals extends Template
{
    protected $helper;

    protected $dataObjectFactory;

    public function __construct(
        Template\Context $context,
        Data $helper,
        DataObjectFactory $dataObjectFactory,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->dataObjectFactory = $dataObjectFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->getParentBlock()->getSource();
    }


    /**
     * @return $this
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $source = $this->getSource();
        $storeId = $source->getStoreId();

        if ($source->getPaymentFee() == 0) {
            return $this;
        }

        $paymentFeeTitle = __("Administration Fee");

        $paymentFeeExclTax = $source->getPaymentFee();
        $basePaymentFeeExclTax = $source->getBasePaymentFee();
        $paymentFeeExclTaxTotal = [
            'code' => 'payment_fee',
            'strong' => false,
            'value' => $paymentFeeExclTax,
            'base_value' => $basePaymentFeeExclTax,
            'label' => $paymentFeeTitle,
        ];

        $parent->addTotal(
            $this->dataObjectFactory->create()->setData($paymentFeeExclTaxTotal),
            'shipping'
        );

        return $this;
    }
}
