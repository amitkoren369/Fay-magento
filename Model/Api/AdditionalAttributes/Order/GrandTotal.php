<?php

namespace Fay\Api\Model\Api\AdditionalAttributes\Order;

use Fay\Api\Model\Api\AdditionalAttributes\Attribute;

class GrandTotal extends Attribute
{
    public function getValue() : string
    {
        return $this->order->getOrderCurrency()->formatPrecision(
            $this->order->getGrandTotal(),
            2,
            [],
            false
        );
    }
}
