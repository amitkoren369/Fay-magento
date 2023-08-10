<?php

namespace Fay\Api\Model\Api\AdditionalAttributes;

use Magento\Sales\Model\Order;

abstract class Attribute
{
    /** @var Order */
    protected $order;

    public function setOrder(Order $order) : Attribute
    {
        $this->order = $order;

        return $this;
    }

    abstract public function getValue() : string;
}
