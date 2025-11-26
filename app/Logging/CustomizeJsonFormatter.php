<?php

namespace App\Logging;

use Monolog\Formatter\JsonFormatter;
use Monolog\LogRecord;
use Illuminate\Support\Facades\Auth;

class CustomizeJsonFormatter extends JsonFormatter
{
    private function toArrayRecursive($data)
    {
        if (is_object($data)) {
            $data = (array) $data;
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->toArrayRecursive($value);
            }
        }

        return $data;
    }

    public function format(LogRecord $record): string
    {
        $normalized = $this->normalizeRecord($record);

        $normalized = $this->toArrayRecursive($normalized);

        $normalized['extra']['user_id']        = Auth::id() ?? '';
        $normalized['extra']['client_ip']      = request()->getClientIp();
        $normalized['extra']['request_url']    = request()->fullUrl();
        $normalized['extra']['request_params'] = request()->all();

        return $this->toJson($normalized, true) . ($this->appendNewline ? "\n" : '');
    }
}
