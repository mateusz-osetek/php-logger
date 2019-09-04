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
     * @param string $message
     */
    public function put(string $message): void;

    /**
     * @param string|null $path
     * @return string|null
     */
    public function read(string $path): ?string;

    /**
     * @param string $to
     * @param string $subject
     */
    public function send(string $to, string $subject): void;

    /**
     * @param string $to
     * @param string $subject
     * @param string $pathToFile
     */
    public function sendAsAttachment(string $to, string $subject, string $pathToFile): void;

    /**
     * @param string $path
     */
    public function wipe(string $path): void;

    /**
     * @param string $path
     */
    public function drop(string $path): void;

    /**
     * @return string|null
     */
    public function getPath(): ?string;

    /**
     * @param string $path
     */
    public function setPath(?string $path): void;

    /**
     * @return string
     */
    public function getFullPath(): string;

    /**
     * @return string|null
     */
    public function getFilename(): ?string;

    /**
     * @param string|null $filename
     */
    public function setFilename(?string $filename): void;

    /**
     * @return string
     */
    public function getDateFormat(): string;

    /**
     * @param string $dateFormat
     */
    public function setDateFormat(string $dateFormat): void;
}
