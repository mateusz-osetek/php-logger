<?php

namespace mosetek\Logger;

class Logger implements LoggerInterface
{
    /**
     * @var string
     */
    private $dateFormat = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    private $pathToLog = '/app/var/logs/';

    /**
     * @var string
     */
    private $filename = 'importer.log';

    public function put(string $message): void
    {
        $message = date($this->dateFormat) . " | {$message}\n";
        file_put_contents($this->pathToLog . $this->filename, $message, FILE_APPEND);
    }

    public function setPath(string $path): void
    {
        $this->pathToLog = $path;
    }

    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    public function setDateFormat(string $dateFormat): void
    {
        $this->dateFormat = $dateFormat;
    }
}
