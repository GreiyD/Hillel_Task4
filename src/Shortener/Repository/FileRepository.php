<?php

namespace App\Shortener\Repository;

use App\Shortener\Interfaces\InterfaceFileRepository;
use InvalidArgumentException;

class FileRepository implements InterfaceFileRepository
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param string $code
     * @param string $url
     * @return bool
     */
    public function saveAll(string $code, string $url): bool
    {
        $filename = $this->getFileName();
        $data = $code . "  |  " . $url . PHP_EOL;
        $result = file_put_contents($filename, $data, FILE_APPEND | LOCK_EX);
        return $result;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function checkUrlFile(string $url): bool
    {
        $fileName = $this->getFileName();
        $content = file_get_contents($fileName);
        if (strpos($content, $url) !== false) {
            return false;
        }
        return true;
    }

    /**
     * @param string $code
     * @return string
     */
    public function getUrl(string $code): string
    {
        $fileName = $this->getFileName();
        $lines = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $parts = explode('  |  ', $line);
            if (count($parts) === 2 && trim($parts[0]) === $code) {
                $url = trim($parts[1]);
                return $url;
            }
        }
        throw new InvalidArgumentException("Не удалось разкодировать, такого Url в базе данных не существует - ");
    }

    /**
     * @param string $url
     * @return string
     */
    public function getCode(string $url): string
    {
        $fileName = $this->getFileName();
        $lines = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $parts = explode(' | ', $line);
            if (count($parts) === 2 && trim($parts[1]) === $url) {
                $code = trim($parts[0]);
                return $code;
            }
        }
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

}

