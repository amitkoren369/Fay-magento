<?php

namespace Fay\Api\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Encryption\EncryptorInterface;

class Config extends AbstractHelper
{
    protected const XML_PATH_API_ENABLED = 'fay/api/is_enabled';
    protected const XML_PATH_TARGET_PRODUCT = 'fay/api/target_product_sku';
    protected const XML_PATH_API_KEY = 'fay/api/api_key';
    protected const XML_PATH_API_ENDPOINT = 'fay/api/api_endpoint';
    protected const XML_PATH_STORE_ID = 'fay/api/store_id';
    protected const XML_PATH_ADDITIONAL_DATA = 'fay/api/external_order_info';
    /** @var EncryptorInterface */
    protected $encryptor;

    public function __construct(Context $context, EncryptorInterface $encryptor)
    {
        parent::__construct($context);
        $this->encryptor = $encryptor;
    }

    public function isApiEnabled() : bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_API_ENABLED);
    }

    public function getTargetProductSku() : ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_TARGET_PRODUCT);
    }

    public function getApiKey() : ?string
    {
        return $this->encryptor->decrypt($this->scopeConfig->getValue(self::XML_PATH_API_KEY));
    }

    public function getApiEndpoint() : ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_API_ENDPOINT);
    }

    public function getStoreId() : ?string
    {
        return $this->scopeConfig->getValue(self::XML_PATH_STORE_ID);
    }

    public function getAdditionalAttributes() : array
    {
        $result = [];
        $value = $this->scopeConfig->getValue(self::XML_PATH_ADDITIONAL_DATA);
        if (is_null($value) === false && $value !== '') {
            $result = explode(',', $value);
        }

        return $result;
    }
}
