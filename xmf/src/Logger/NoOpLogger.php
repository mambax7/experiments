<?php declare(strict_types=1);

namespace Xmf\Logger;

use Psr\Log\LoggerInterface;

class NoOpLogger implements LoggerInterface
{
    public function emergency($message, array $context = []): void
    {
        // Do nothing
    }

    public function alert($message, array $context = []): void
    {
        // Do nothing
    }

    public function critical($message, array $context = []): void
    {
        // Do nothing
    }

    public function error($message, array $context = []): void
    {
        // Do nothing
    }

    public function warning($message, array $context = []): void
    {
        // Do nothing
    }

    public function notice($message, array $context = []): void
    {
        // Do nothing
    }

    public function info($message, array $context = []): void
    {
        // Do nothing
    }

    public function debug($message, array $context = []): void
    {
        // Do nothing
    }

    public function log($level, $message, array $context = []): void
    {
        // Do nothing
    }
}
