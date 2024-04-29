<?php declare(strict_types=1);

namespace Xmf\Logger;

use Monolog\Logger as MonologLogger;
use Psr\Log\LoggerInterface;

class Logger
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this->logger, $method)) {
            return $this->logger->$method(...$parameters);
        }

        throw new \BadMethodCallException("Method '$method' does not exist.");
    }
}
