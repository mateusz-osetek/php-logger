<?php

namespace mosetek\Logger;

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
     */
    public function send(string $to): void;

    /**
     * @param string $path
     */
    public function wipe(string $path): void;

    /**
     * @param string $path
     */
    public function drop(string $path): void;

    /**
     * @param string $path
     */
    public function setPath(string $path): void;

    /**
     * @return string|null
     */
    public function getPath(): ?string;

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void;

    /**
     * @param string $dateFormat
     */
    public function setDateFormat(string $dateFormat): void;
}
