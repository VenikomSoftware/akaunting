<?php

namespace PaymentGatewayJson\Client\Schedule;

/**
 * Class StartSchedule
 */
class StartSchedule
{
    const PERIOD_UNIT_DAY = 'DAY';

    const PERIOD_UNIT_WEEK = 'WEEK';

    const PERIOD_UNIT_MONTH = 'MONTH';

    const PERIOD_UNIT_YEAR = 'YEAR';

    /**
     * reference UUID of initial register
     *
     * @var string
     */
    protected $registrationUuid;

    /** @var float */
    protected $amount;

    /** @var string */
    protected $currency;

    /** @var int */
    protected $periodLength;

    /** @var string */
    protected $periodUnit;

    /** @var \DateTime */
    protected $startDateTime;

    /**
     * @return string
     */
    public function getRegistrationUuid()
    {
        return $this->registrationUuid;
    }

    /**
     * @param  string  $registrationUuid
     * @return StartSchedule
     */
    public function setRegistrationUuid($registrationUuid)
    {
        $this->registrationUuid = $registrationUuid;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param  float  $amount
     * @return StartSchedule
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param  string  $currency
     * @return StartSchedule
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return int
     */
    public function getPeriodLength()
    {
        return $this->periodLength;
    }

    /**
     * @param  int  $periodLength
     * @return StartSchedule
     */
    public function setPeriodLength($periodLength)
    {
        $this->periodLength = $periodLength;

        return $this;
    }

    /**
     * @return string
     */
    public function getPeriodUnit()
    {
        return $this->periodUnit;
    }

    /**
     * @param  string  $periodUnit
     * @return StartSchedule
     */
    public function setPeriodUnit($periodUnit)
    {
        $this->periodUnit = $periodUnit;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * @param  \DateTime|string  $startDateTime
     * @return StartSchedule
     *
     * @throws \Exception
     */
    public function setStartDateTime($startDateTime)
    {
        if (! empty($startDateTime) && is_string($startDateTime)) {
            $startDateTime = new \DateTime($startDateTime);
        }
        $this->startDateTime = $startDateTime;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'registrationUuid' => $this->getRegistrationUuid(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'periodLength' => $this->getPeriodLength(),
            'periodUnit' => $this->getPeriodUnit(),
            'startDateTime' => $this->getStartDateTime()->format(\DateTime::ATOM),
        ];
    }
}
