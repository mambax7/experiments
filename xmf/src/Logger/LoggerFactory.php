<?php declare(strict_types=1);

namespace Xmf\Logger;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
//use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\NullHandler;

class LoggerFactory
{
    public static function getLogger($name, $enabled, $logFile)
    {
        $logger = new MonologLogger($name);

        if ((int)$enabled === 1) {
            $logLevel   = MonologLogger::DEBUG;
            $handler    = new StreamHandler($logFile, $logLevel);
            $dateFormat = "Y-m-d, H:i:s";
            $output     = "%datetime% | %level_name% | $name: %message% | %context% %extra%\n";
            $handler->setFormatter(new LineFormatter($output, $dateFormat));
            $logger->pushHandler($handler);
        } else {
            $handler = new NullHandler();
            $logger->pushHandler($handler);
        }

        return new Logger($logger);
    }
}
