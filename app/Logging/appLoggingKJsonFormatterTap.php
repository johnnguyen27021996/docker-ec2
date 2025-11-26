<?php

namespace App\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\JsonFormatter;
use App\Logging\CustomizeJsonFormatter;

class KJsonFormatterTap
{
    /**
     * Customize the given logger instance.
     */
    public function __invoke(Logger $logger): void
    {
        $formatter = new CustomizeJsonFormatter(
            JsonFormatter::BATCH_MODE_JSON,
            true
        );

        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($formatter);
        }
    }
}
