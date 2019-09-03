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
    private $path = 'logs/';

    /**
     * @var string
     */
    private $filename = 'error.log';

    /**
     * @var string
     */
    protected $fullPath;

    public function __construct()
    {
        $this->fullPath = $this->path . $this->filename;
    }

    public function put(string $message): void
    {
        $message = date($this->dateFormat) . " | {$message}\n";
        file_put_contents($this->fullPath, $message, FILE_APPEND);
    }

    public function read(string $path = ''): ?string
    {
        if (empty($path)) {
            $path = $this->fullPath;
        }
        return file_get_contents($path);
    }

    public function send(string $to): void
    {
        mail(
            $to,
            'Log information from ' . date($this->dateFormat),
            $this->read()
        );
    }

    public function wipe(string $path = ''): void
    {
        if (empty($path)) {
            $path = $this->fullPath;
        }
        file_put_contents($path, '');
    }

    public function drop(string $path = ''): void
    {
        if (empty($path)) {
            $path = $this->fullPath;
        }
        unlink($path);
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getPath(): ?string
    {
        return $this->path . $this->filename;
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
