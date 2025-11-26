<?php
 
namespace App\Logging;
 
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FilterHandler;
use Monolog\Level;
 
class KStdoutLogger
{
    /**
     * Create a custom Monolog instance.
     */
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('k-report-api_stdout');
 
        $handler = app()->make(StreamHandler::class, [
            'stream' => 'php://stdout',
            'level' => Level::Debug,
        ]);
 
        $filterHandler = app()->make(FilterHandler::class, [
            'handler' => $handler,
            'minLevel' => Level::Info,
            'maxLevel' => Level::Warning,
        ]);
 
        $logger->pushHandler($filterHandler);
 
        return $logger;
    }
}
