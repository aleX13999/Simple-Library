<?php

namespace App\Services;

class BookLogger extends LoggerAbstract
{
    public function __construct()
    {
        parent::__construct('books');
    }

    public function log(string $message, array $context = []): void
    {
        if (isset($context['id'])) {
            $context['id'] = (int) $context['id'];
        }

        if (isset($context['type'])) {
            $context['type'] = $context['type']->value;
        }

        if (isset($context['createdAt']) && method_exists($context['createdAt'], 'toDateTimeString')) {
            $context['createdAt'] = $context['createdAt']->toDateTimeString();
        }

        $this->writeLog($message, $context);
    }
}
