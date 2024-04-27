<?php declare(strict_types=1);

namespace Xmf\Logger;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\NullHandler;

class LoggerFactory
{
    public static function getLogger($name, $enabled, $logFile)
    {
        $logger = new MonologLogger($name);

        if ((int)$enabled === 1) {
            $logLevel = MonologLogger::DEBUG;
            $handler  = new StreamHandler($logFile, $logLevel);
            $logger->pushHandler($handler);
        } else {
            $handler = new NullHandler();
            $logger->pushHandler($handler);
        }

        return new Logger($logger);
    }
}
