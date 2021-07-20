define([
    'Magento_Checkout/js/view/summary/abstract-total',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/totals'
], function(Component, quote, totals) {
    "use strict";

    return Component.extend({
        defaults: {
            template: 'Boostsales_Paymentfee/cart/totals/fee'
        },
        totals: quote.getTotals(),
        title: window.checkoutConfig.Boostsales_paymentfee.title,

        isDisplayed: function() {
            return this.getPaymentFee() != 0;
        },

        getPaymentFee: function() {
            var price = 0;
            if (this.totals() && totals.getSegment('payment_fee')) {
                if(totals.getSegment('grand_total').value < 250){
                    price = parseFloat(totals.getSegment('payment_fee').value);
                }
            }
            return price;
        },

        getValue: function() {
            return this.getFormattedPrice(this.getPaymentFee());
        },

        getPaymentFeeExclTax: function() {
            return this.getValue();
        },

        getPaymentFeeInclTax: function() {
            var price = 0;
            if (this.totals() && totals.getSegment('payment_fee')) {
                price = totals.getSegment('payment_fee_incl_tax').value;
            }
            return this.getFormattedPrice(price);
        }
    });
});