<?php

namespace mosetek\Logger;

use mosetek\Logger\MailerClient;

/**
 * @author Mateusz Osetek <osetek.mateusz@gmail.com>
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
    private $filename;

    /**
     * @var string
     */
    private $fullPath;

    /**
     * @var MailerClient
     */
    private $mailerClient;

    /**
     * Logger constructor.
     *
     * @param string $path
     * @param string $filename
     * @param string $dateFormat
     */
    public function __construct(string $path = 'logs', string $filename = '.log', string $dateFormat = 'Y-m-d H:i:s')
    {
        $this->path = $path;
        $this->filename = $filename;
        $this->dateFormat = $dateFormat;
        $this->setFullPath();
    }

    /**
     * Put content into a file.
     *
     * @param string $message
     */
    public function put(string $message): void
    {
        $message = date($this->dateFormat) . " | {$message}".PHP_EOL;
        $flag = file_exists($this->getFullPath()) ? FILE_APPEND : 0;
        file_put_contents($this->fullPath, $message, $flag);
    }

    /**
     * Read content of a log file.
     *
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
     * Email a log file.
     *
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
     *
     */
    public function sendAsAttachment(): void
    {
        $this->mailerClient->send();
    }

    /**
     * Empty content of a log file.
     *
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
     * Delete a file.
     *
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
     * Get full path to a log file.
     *
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * Set path to a file.
     *
     * @param string|null $path
     */
    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    /**
     * Get a log file path.
     *
     * @return string
     */
    public function getFullPath(): string
    {
        $this->setFullPath();
        return $this->fullPath;
    }

    /**
     * Get a log file name.
     *
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * Set a log file name.
     *
     * @param string|null $filename
     */
    public function setFilename(?string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * Return a log file size.
     *
     * @param string|null $path
     * @param string $unit
     * @return float|null
     */
    public function getFilesize(?string $unit = 'MB', ?string $path = ''): ?float
    {
        if (empty($path)) {
            $path = $this->getFullPath();
        }
        $filesize = filesize($path);
        switch ($unit) {
            case 'B':
                return $filesize;
                break;
            case 'KB':
                return $filesize * (10 ** -3);
                break;
            case 'GB':
                return $filesize * (10 ** -9);
                break;
            default:
                return $filesize * (10 ** -6);
        }
    }

    /**
     * Get a log file date format.
     *
     * @return string
     */
    public function getDateFormat(): string
    {
        return $this->dateFormat;
    }

    /**
     * Set a log file date format.
     *
     * @param string $dateFormat
     */
    public function setDateFormat(string $dateFormat): void
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * Sets current log file full path.
     */
    private function setFullPath(): void
    {
        $this->fullPath = $this->formatPath();
    }

    /**
     * @return string
     */
    private function formatPath(): string
    {
        $this->path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $this->path);
        $this->filename = str_replace(['\\', '/'], ['/', ''], $this->filename);

        if (!mkdir($concurrentDirectory = $this->path) && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        return $this->path.DIRECTORY_SEPARATOR.$this->filename;
    }
}
