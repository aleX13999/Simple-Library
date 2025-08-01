<?php

namespace App\Application\Logger;

interface LoggerInterface
{
    public function log(string $message, array $context = []): void;
}
