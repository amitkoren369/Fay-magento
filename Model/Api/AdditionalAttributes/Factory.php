<?php

namespace Fay\Api\Model\Api\AdditionalAttributes;

use Fay\Api\Model\Api\AdditionalAttributes\Order\CreatedDate;
use Fay\Api\Model\Api\AdditionalAttributes\Order\GrandTotal;
use Fay\Api\Model\Api\AdditionalAttributes\Order\ShippingAddress;
use Fay\Api\Model\Api\AdditionalAttributes\Order\ShippingMethod;

class Factory
{
    /** @var array */
    protected $attributes = [];

    public function __construct(
        CreatedDate $createdDate,
        ShippingMethod $shippingMethod,
        GrandTotal $grandTotal,
        ShippingAddress $shippingAddress
    ) {
        $this->attributes['order_created_date'] = $createdDate;
        $this->attributes['order_shipping_method'] = $shippingMethod;
        $this->attributes['order_grand_total'] = $grandTotal;
        $this->attributes['order_shipping_address'] = $shippingAddress;
    }

    public function getAttributeModel(string $attribute) : Attribute
    {
        if (array_key_exists($attribute, $this->attributes)) {
            return $this->attributes[$attribute];
        }

        throw new NotFoundException(__('Attribute %1 is not found. Please contact service provider.', $attribute));
    }
}
