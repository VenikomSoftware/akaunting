<?php

namespace PaymentGateway\Client\Transaction;

use PaymentGateway\Client\Transaction\Base\AbstractTransactionWithReference;
use PaymentGateway\Client\Transaction\Base\AddToCustomerProfileInterface;
use PaymentGateway\Client\Transaction\Base\AddToCustomerProfileTrait;
use PaymentGateway\Client\Transaction\Base\AmountableInterface;
use PaymentGateway\Client\Transaction\Base\AmountableTrait;
use PaymentGateway\Client\Transaction\Base\ItemsInterface;
use PaymentGateway\Client\Transaction\Base\ItemsTrait;
use PaymentGateway\Client\Transaction\Base\OffsiteInterface;
use PaymentGateway\Client\Transaction\Base\OffsiteTrait;
use PaymentGateway\Client\Transaction\Base\ScheduleInterface;
use PaymentGateway\Client\Transaction\Base\ScheduleTrait;

/**
 * Preauthorize: Reserve a certain amount, which can be captured (=charging) or voided (=revert) later on.
 */
class Preauthorize extends AbstractTransactionWithReference implements AmountableInterface, OffsiteInterface, ItemsInterface, ScheduleInterface, AddToCustomerProfileInterface
{
    use OffsiteTrait;
    use AmountableTrait;
    use ItemsTrait;
    use ScheduleTrait;
    use AddToCustomerProfileTrait;

    const TRANSACTION_INDICATOR_SINGLE = 'SINGLE';

    const TRANSACTION_INDICATOR_INITIAL = 'INITIAL';

    const TRANSACTION_INDICATOR_RECURRING = 'RECURRING';

    const TRANSACTION_INDICATOR_CARDONFILE = 'CARDONFILE';

    const TRANSACTION_INDICATOR_CARDONFILE_MERCHANT = 'CARDONFILE_MERCHANT';

    /**
     * @var bool
     */
    protected $withRegister = false;

    /**
     * @var string
     */
    protected $transactionIndicator;

    /**
     * @return bool
     */
    public function isWithRegister()
    {
        return $this->withRegister;
    }

    /**
     * set true if you want to register a user vault together with the preauthorize
     *
     * @param  bool  $withRegister
     * @return $this
     */
    public function setWithRegister($withRegister)
    {
        $this->withRegister = $withRegister;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionIndicator()
    {
        return $this->transactionIndicator;
    }

    /**
     * @param  string  $transactionIndicator
     */
    public function setTransactionIndicator($transactionIndicator)
    {
        $this->transactionIndicator = $transactionIndicator;

        return $this;
    }
}
