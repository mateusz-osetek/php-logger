<?php

namespace mosetek\Logger;

interface LoggerInterface
{
    /**
     * @param string $message
     */
    public function put(string $message): void;

    /**
     * @param string $path
     */
    public function setPath(string $path): void;

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void;

    /**
     * @param string $dateFormat
     */
    public function setDateFormat(string $dateFormat): void;
}
