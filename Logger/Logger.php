<?php

namespace mosetek\Logger;

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
        $this->mailerClient = new MailerClient();
        $this->setFullPath();
    }

    /**
     * Put content into a file.
     *
     * @param string $message
     * @param int $level
     */
    public function put(string $message, int $level = 0): void
    {
        $message = date($this->dateFormat) . " {$this->getErrorLevel($level)} | {$message}" . PHP_EOL;
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
        return file_get_contents($path ?: $this->getFullPath());
    }

    /**
     * Move log file to another directory
     *
     * @param string $to
     * @param string $from
     */
    public function move(string $to, string $from = ''): void
    {
        $from ?: $this->getFullPath();
        $this->copy($to, $from);
        $this->drop($from);
    }

    /**
     * Copy log file to another directory
     *
     * @param string $to
     * @param string $from
     */
    public function copy(string $to, string $from = ''): void
    {
        file_put_contents($to, $this->read($from ?: $this->getFullPath()));
    }

    /**
     * @deprecated use Logger::sendAsAttachment() instead
     * Email a log file.
     *
     * @param string $to
     * @param string $subject
     */
    public function send(string $to, string $subject = ''): void
    {
        mail(
            $to,
            $subject ?: 'Log information from ' . date($this->dateFormat),
            $this->read()
        );
    }

    /**
     * @param string $to
     * @param string $attachment
     * @param string $message
     */
    public function sendAsAttachment(string $to, string $attachment = '', string $message = ''): void
    {
        $this->mailerClient->send($to, $attachment ?: $this->getFullPath(), $message);
    }

    /**
     * Empty content of a log file.
     *
     * @param string $path
     */
    public function wipe(string $path = ''): void
    {
        file_put_contents($path ?: $this->getFullPath(), '');
    }

    /**
     * Delete a file.
     *
     * @param string $path
     */
    public function drop(string $path = ''): void
    {
        unlink($path ?: $this->getFullPath());
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
        $path = $path ?: $this->getFullPath();
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

        $this->createDirectoryIfNotExist($this->path);

        return $this->path . DIRECTORY_SEPARATOR . $this->filename;
    }

    private function createDirectoryIfNotExist(string $path, int $mode = 0755): void
    {
        if (false === is_dir($path)) {
            mkdir($path, $mode, true);
        }
    }

    private function getErrorLevel(int $level): string
    {
        switch ($level) {
            case 1: return '[INFO]'; break;
            case 2: return '[WARNING]'; break;
            case 3: return '[ERROR]'; break;
            default: return '';
        }
    }
}
