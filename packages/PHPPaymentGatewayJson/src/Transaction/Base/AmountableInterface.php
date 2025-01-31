<?php

namespace PaymentGatewayJson\Client\Transaction\Base;

/**
 * Interface AmountableInterface
 */
interface AmountableInterface
{
    /**
     * @return float
     */
    public function getAmount();

    /**
     * the amount you want to charge/refund etc.
     *
     * @param  float  $amount
     */
    public function setAmount($amount);

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @param  string  $currency
     */
    public function setCurrency($currency);
}
