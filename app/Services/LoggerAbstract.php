<?php

namespace App\Services;

use App\Application\Logger\LoggerInterface;
use Illuminate\Support\Facades\Log;

abstract class LoggerAbstract implements LoggerInterface
{
    protected string $channel;

    protected string $logLevel = 'info';

    public function __construct(string $channel = 'single')
    {
        $this->channel = $channel;
    }

    protected function writeLog(string $message, array $context = []): void
    {
        try {
            $channelLogger = Log::channel($this->channel);

            if (method_exists(Log::channel($this->channel), $this->logLevel)) {
                $channelLogger->{$this->logLevel}($message, $context);
            } else {
                $channelLogger->info($message, $context);
            }
        } catch (\Throwable $e) {
            Log::error("Logging failed on channel '{$this->channel}': " . $e->getMessage());
        }
    }

    abstract public function log(string $message, array $context = []): void;

    public function getLogLevel(): string
    {
        return $this->logLevel;
    }

    public function setLogLevel(string $logLevel): static
    {
        $this->logLevel = $logLevel;

        return $this;
    }
}
