<?php

namespace Fay\Api\Model\Api\AdditionalAttributes\Order;

use Fay\Api\Model\Api\AdditionalAttributes\Attribute;

class ShippingMethod extends Attribute
{
   public function getValue() : string
   {
       return $this->order->getShippingMethod();
   }
}
