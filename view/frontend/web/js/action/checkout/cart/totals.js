define([
    'ko',
    'jquery',
    'Magento_Checkout/js/model/quote',
    'mage/storage',
    'mage/url',
    'Magento_Checkout/js/action/get-totals',
    'Magento_Checkout/js/model/full-screen-loader'
], function(ko, $, quote, storage, urlBuilder, getTotalsAction, fullScreenLoader) {
    'use strict';
    var total = parseFloat(quote.totals().subtotal);
    return function(isLoading, payment) {
        if (payment == "checkmo" && total < 250) {
            fullScreenLoader.startLoader();
            return storage.post(
                urlBuilder.build('paymentfee/calculate/paymentfee'),
                JSON.stringify({ payment: payment })
            ).done(function(response) {
                if (response) {
                    let deferred = $.Deferred();
                    isLoading(false);
                    getTotalsAction([], deferred);
                }
            }).fail(function() {
                isLoading(false);
            }).always(function() {
                fullScreenLoader.stopLoader();
            });
        }
    };
});