<?php

namespace Fay\Api\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Class Handler
 * @package Fay\Api\Logger
 */
class Handler extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/fay_api.log';

    /**
     * @var int
     */
    protected $loggerType = Logger::INFO;
}
