<?php

namespace App\Shortener\Interfaces;

interface InterfaceUrlEncoder
{

    /**
     * @param string $url
     * @return string
     * @throws \InvalidArgumentException
     */
    public function encode(string $url): string;
}