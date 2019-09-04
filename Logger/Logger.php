<?php

namespace mosetek\Logger;

class Logger implements LoggerInterface
{
    /**
     * @var string
     */
    private $dateFormat;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $fullPath;

    public function __construct(string $path = 'logs/', string $filename = '.log', string $dateFormat = 'Y-m-d H:i:s')
    {
        $this->path = $path;
        $this->filename = $filename;
        $this->dateFormat = $dateFormat;
        $this->fullPath = $this->formatPath();
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

    public function getPath(): ?string
    {
        return $this->fullPath;
    }

    private function formatPath(): string
    {
        $this->path = str_replace('\\', '/', $this->path);
        $this->filename = str_replace(['\\', '/'], ['/', ''], $this->filename);
        if ('/' !== substr($this->path, -1)) {
            $this->path .= '/';
        }
        return $this->path . $this->filename;
    }
}
