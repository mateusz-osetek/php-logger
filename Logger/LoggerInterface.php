<?php

namespace mosetek\Logger;

/**
 * @author Mateusz Osetek <osetek.mateusz@gmail.com>
 */

interface LoggerInterface
{
    /**
     * Put content into a file.
     *
     * @param mixed $message
     * @param int $level
     * @param string $path
     */
    public function put($message, int $level, string $path): void;

    /**
     * Read content of a log file.
     *
     * @param string|null $path
     * @return string|null
     */
    public function read(string $path): ?string;

    /**
     * Move log file to another directory
     *
     * @param string $to
     * @param string $from
     */
    public function move(string $to, string $from): void;

    /**
     * Copy log file to another directory
     *
     * @param string $to
     * @param string $from
     */
    public function copy(string $to, string $from): void;

    /**
     * Email a log file.
     *
     * @param string $to
     * @param string $subject
     */
    public function send(string $to, string $subject): void;

    /**
     * Email a log file as an attachment
     *
     * @param string $to
     * @param string $attachment
     * @param string $message
     */
    public function sendAsAttachment(string $to, string $attachment, string $message): void;

    /**
     * @deprecated use Logger::sendAsAttachment() instead
     * Empty content of a log file.
     *
     * @param string $path
     */
    public function wipe(string $path): void;

    /**
     * Delete a file.
     *
     * @param string $path
     */
    public function drop(string $path): void;

    /**
     * Show variable representation of specific expression
     *
     * @param $expression
     * @param int $level
     * @return void
     */
    public function dump($expression, int $level): void;

    /**
     * Get full path to a log file.
     *
     * @return string|null
     */
    public function getPath(): ?string;

    /**
     * Set path to a file.
     *
     * @param string $path
     */
    public function setPath(?string $path): void;

    /**
     * Get a log file path.
     *
     * @return string
     */
    public function getFullPath(): string;

    /**
     * Get a log file name.
     *
     * @return string|null
     */
    public function getFilename(): ?string;

    /**
     * Set a log file name.
     *
     * @param string|null $filename
     */
    public function setFilename(?string $filename): void;

    /**
     * Return a log file size.
     *
     * @param string|null $path
     * @param string $unit
     * @return float|null
     */
    public function getFilesize(string $unit, ?string $path): ?float;

    /**
     * Get a log file date format.
     *
     * @return string
     */
    public function getDateFormat(): string;

    /**
     * Set a log file date format.
     *
     * @param string $dateFormat
     */
    public function setDateFormat(string $dateFormat): void;
}
