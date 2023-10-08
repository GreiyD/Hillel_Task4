<?php

namespace App\DI;

use App\DI\Interfaces\ContainerInterface;
use App\DI\Exceptions\NotFoundException;

class Container implements ContainerInterface
{
    /**
     * @var array
     */
    private $services = [];

    /**
     * @param string $key
     * @param $service
     * @return void
     */
    public function add(string $key, $service)
    {
        $this->services[$key] = $service;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws NotFoundException
     */
    public function get(string $key): mixed
    {
        if ($this->has($key)) {
            if (is_callable($this->services[$key])) {
                $service = $this->services[$key]($this);
                $this->services[$key] = $service;
                return $service;
            } else {
                return $this->services[$key];
            }
        } else {
            throw new NotFoundException("Service not found: $key");
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->services[$key]);
    }
}