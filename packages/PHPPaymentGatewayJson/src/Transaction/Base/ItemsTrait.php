<?php

namespace PaymentGatewayJson\Client\Transaction\Base;

use PaymentGatewayJson\Client\Data\Item;

/**
 * Class ItemsTrait
 */
trait ItemsTrait
{
    /** @var Item[] */
    protected $items = [];

    /**
     * @param  Item[]  $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param  Item  $item
     * @return $this
     */
    public function addItem($item)
    {
        $this->items[] = $item;

        return $this;
    }
}
