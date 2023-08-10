<?php

namespace Fay\Api\Observer;

use Fay\Api\Logger\Logger;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Fay\Api\Helper\Data;
use Fay\Api\Model\Api;

class CheckCartAndSendApiCall implements ObserverInterface
{
    /** @var Logger */
    protected $logger;
    /** @var Data */
    protected $helper;
    /** @var Api */
    protected $api;

    public function __construct(
        Logger $logger,
        Data $helper,
        Api $api
    ) {
        $this->logger = $logger;
        $this->helper = $helper;
        $this->api = $api;
    }

    public function execute(Observer $observer) : void
    {
        if ($this->helper->isApiEnabled()) {
            $this->logger->info('It is enabled');
            /** @var Order $order */
            $order = $observer->getData('order');
            if ($this->helper->isOrderFitRequirements($order)) {
                $this->logger->info('call api');
                try {
                    $this->api->callOrderCreate($this->helper->generateDataForApi($order));
                } catch (\RuntimeException $e) {
                    $this->logger->critical($e);
                }
            }
        }
    }
}
