<?php

namespace Fay\Api\Helper;

use Fay\Api\Model\Api\AdditionalAttributes\Factory;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Sales\Model\Order;
use Magento\Framework\Serialize\Serializer\Json;

class Data extends AbstractHelper
{
    protected Config $config;
    protected Json $json;
    protected Factory $attributeFactory;

    public function __construct(Context $context, Config $config, Json $json, Factory $attributeFactory)
    {
        parent::__construct($context);
        $this->config = $config;
        $this->json = $json;
        $this->attributeFactory = $attributeFactory;
    }

    /**
     * It's disabled if we've no token available
     * @return bool
     */
    public function isApiEnabled() : bool
    {
        return $this->config->isApiEnabled() && $this->config->getApiKey() && $this->config->getApiEndpoint();
    }

    public function getTargetProductSku() : ?string
    {
        return $this->config->getTargetProductSku();
    }

    public function isOrderFitRequirements(Order $order) : bool
    {
        if ($this->getTargetProductSku()) {
            foreach ($order->getAllItems() as $item) {
                if ($item->getSku() === $this->getTargetProductSku()) {
                    return true;
                }
            }
        }

        return false;
    }

    public function generateDataForApi(Order $order) : array
    {
        return [
            'store_id' => $this->config->getStoreId(),
            'buyer_phone' => $order->getShippingAddress()->getTelephone(),
            'order_id' => $order->getIncrementId(),
            'order_info' => $this->getExternalOrderInfo($order),
            'buyer_name' => $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname(),
        ];
    }

    protected function getExternalOrderInfo(Order $order) : string
    {
        $data = [];
        $attributes = $this->config->getAdditionalAttributes();
        if (!empty($attributes))  {
            foreach ($attributes as $attributeCode) {
                $data[$attributeCode] = $this->attributeFactory->getAttributeModel($attributeCode)->setOrder($order)->getValue();
            }
        }

        return (string)$this->json->serialize($data);
    }
}
