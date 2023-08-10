<?php

namespace Fay\Api\Model\Api\AdditionalAttributes\Order;

use Fay\Api\Model\Api\AdditionalAttributes\Attribute;
use Magento\Directory\Model\CountryFactory;

class ShippingAddress extends Attribute
{
    /** @var CountryFactory */
    protected $countryFactory;

    public function __construct(CountryFactory $countryFactory)
    {
        $this->countryFactory = $countryFactory;
    }

    public function getValue() : string
    {
        $address = $this->order->getShippingAddress();

        return sprintf('%s %s %s %s %s',
            $this->getCountryNameByCode($address->getCountryId()),
            $address->getCity(),
            implode(',', $address->getStreet()),
            $address->getFirstname(),
            $address->getLastname()
        );
    }

    protected function getCountryNameByCode(string $countryCode) : string
    {
        return $this->countryFactory->create()->loadByCode($countryCode)->getName();
    }
}
