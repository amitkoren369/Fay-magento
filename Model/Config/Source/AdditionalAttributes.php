<?php

namespace Fay\Api\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class AdditionalAttributes implements OptionSourceInterface
{

    public function toOptionArray() : array
    {
        return [
            [
                'label' => __('Order created date'),
                'value' => 'order_created_date',
            ],
            [
                'label' => __('Order shipping method'),
                'value' => 'order_shipping_method',
            ],
            [
                'label' => __('Order shipping address'),
                'value' => 'order_shipping_address',
            ],
            [
                'label' => __('Order grand total'),
                'value' => 'order_grand_total',
            ]
        ];
    }
}
