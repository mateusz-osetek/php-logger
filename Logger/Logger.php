<?php

namespace mosetek\Logger;

/**
 * @author Mateusz Osetek
 * @email osetek.mateusz@gmail.com
 * @license MIT
 */

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

    /**
     * Logger constructor.
     * @param string $path
     * @param string $filename
     * @param string $dateFormat
     */
    public function __construct(string $path = 'logs/', string $filename = '.log', string $dateFormat = 'Y-m-d H:i:s')
    {
        $this->path = $path;
        $this->filename = $filename;
        $this->dateFormat = $dateFormat;
        $this->setFullPath();
    }

    /**
     * @param string $message
     */
    public function put(string $message): void
    {
        $message = date($this->dateFormat) . " | {$message}\n";
        file_put_contents($this->getFullPath(), $message, FILE_APPEND);
    }

    /**
     * @param string $path
     * @return string|null
     */
    public function read(string $path = ''): ?string
    {
        if (empty($path)) {
            $path = $this->getFullPath();
        }
        return file_get_contents($path);
    }

    /**
     * @param string $to
     * @param string $subject
     */
    public function send(string $to, string $subject = ''): void
    {
        if (empty($subject)) {
            $subject = 'Log information from ' . date($this->dateFormat);
        }
        mail(
            $to,
            $subject,
            $this->read()
        );
    }

    /**
     * @param string $to
     * @param string $subject
     * @param string $pathToFile
     */
    public function sendAsAttachment(string $to, string $subject, string $pathToFile): void
    {
        // TODO: Implement sendAsAttachment() method.
    }

    /**
     * @param string $path
     */
    public function wipe(string $path = ''): void
    {
        if (empty($path)) {
            $path = $this->getFullPath();
        }
        file_put_contents($path, '');
    }

    /**
     * @param string $path
     */
    public function drop(string $path = ''): void
    {
        if (empty($path)) {
            $path = $this->getFullPath();
        }
        unlink($path);
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     */
    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * @param string $dateFormat
     */
    public function setDateFormat(string $dateFormat): void
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * @return string
     */
    public function getFullPath(): string
    {
        $this->setFullPath();
        return $this->fullPath;
    }

    private function setFullPath(): void
    {
        $this->fullPath = $this->formatPath();
    }

    /**
     * @return string
     */
    private function formatPath(): string
    {
        $this->path = str_replace('\\', '/', $this->path);
        $this->filename = str_replace(['\\', '/'], ['/', ''], $this->filename);
        if (false === empty($this->path) && '/' !== substr($this->path, -1)) {
            $this->path .= '/';
        }
        return $this->path . $this->filename;
    }
}
