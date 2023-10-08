<?php

namespace App\Shortener\Interfaces;

interface InterfaceFileRepository
{
    /**
     * @param string $code
     * @param string $url
     * @return bool
     */
    public function saveAll(string $code, string $url): bool;

    /**
     * @param string $url
     * @return bool
     */
    public function checkUrlFile(string $url): bool;

    /**
     * @param string $code
     * @return string
     */
    public function getUrl(string $code): string;

    /**
     * @param string $url
     * @return string
     */
    public function getCode(string $url): string;
}