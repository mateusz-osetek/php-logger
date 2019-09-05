<?php

namespace mosetek\Logger;

/**
 * @author Mateusz Osetek
 * @email osetek.mateusz@gmail.com
 * @license MIT
 */

interface LoggerInterface
{
    /**
     * Put content into a file.
     *
     * @param string $message
     */
    public function put(string $message): void;

    /**
     * Read content of a log file.
     *
     * @param string|null $path
     * @return string|null
     */
    public function read(string $path): ?string;

    /**
     * Email a log file.
     *
     * @param string $to
     * @param string $subject
     */
    public function send(string $to, string $subject): void;

    /**
     * Emplty content of a log file.
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
