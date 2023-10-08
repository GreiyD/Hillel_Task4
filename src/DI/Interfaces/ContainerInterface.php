<?php

namespace App\DI\Interfaces;

interface ContainerInterface
{
    public function get(string $key): mixed;
    public function has(string $key): bool;
}