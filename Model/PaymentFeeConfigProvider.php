<?php
namespace Boostsales\Paymentfee\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Boostsales\Paymentfee\Helper\Data;

class PaymentFeeConfigProvider implements ConfigProviderInterface
{

    protected $helper;

    public function __construct(Data $helper) {
        $this->helper = $helper;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $paymentFeeConfig = [
            'Boostsales_paymentfee' => [
                'title' => __('Administration Fee'),
            ]
        ];

        return $paymentFeeConfig;
    }
}
