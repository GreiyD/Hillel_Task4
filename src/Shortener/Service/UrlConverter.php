<?php

namespace App\Shortener\Service;

use App\Shortener\Interfaces\InterfaceUrlEncoder;
use App\Shortener\Interfaces\InterfaceUrlDecoder;
use App\Shortener\Repository\FileRepository;
use App\Shortener\Helpers\Validation\UrlValidator;
use Exception;
use InvalidArgumentException;

class UrlConverter implements InterfaceUrlDecoder, InterfaceUrlEncoder
{
    /**
     * @var UrlValidator
     */
    protected $validator;
    /**
     * @var FileRepository
     */
    protected $fileRepository;
    /**
     * @var
     */
    protected $numberCharCode;
    /**
     * @var
     */
    protected $codeSalt;

    /**
     * @param UrlValidator $validator
     * @param FileRepository $fileRepository
     * @param $numberCharCode
     * @param $codeSalt
     */
    public function __construct(UrlValidator $validator, FileRepository $fileRepository, $numberCharCode, $codeSalt)
    {
        $this->validator = $validator;
        $this->fileRepository = $fileRepository;
        $this->numberCharCode = $numberCharCode;
        $this->codeSalt = $codeSalt;
    }

    /**
     * @param string $url
     * @return string
     */
    public function encode(string $url): string
    {
        $result = $this->prepareUrl($url);
        return $result;
    }

    /**
     * @param string $url
     * @return string
     */
    public function prepareUrl(string $url): string
    {
        $this->validator->validation($url);
        if (http_response_code() === 200) {
            if ($this->fileRepository->checkUrlFile($url)) {
                $code = $this->codingUrl($url);
                if ($this->fileRepository->saveAll($code, $url)) {
                    return $code;
                } else {
                    throw new Exception("Код и URL не были сохранены - ");
                }
            } else {
                return $this->fileRepository->getCode($url);
            }
        } elseif (http_response_code() === 400) {
            throw new InvalidArgumentException("URL не существует или недоступен - ");
        }
    }

    /**
     * @param string $url
     * @return string
     */
    protected function codingUrl(string $url): string
    {
        $codeSalt = $this->getCodeSalt();
        $numberCharCode = $this->getNumberCharCode();

        $url = $url . $codeSalt;
        $urlArray = str_split($url);
        shuffle($urlArray);
        $urlShuffled = implode('', $urlArray);
        return mb_substr($urlShuffled, 0, $numberCharCode);
    }

    /**
     * @param string $code
     * @return string
     */
    public function decode(string $code): string
    {
        return $this->fileRepository->getUrl($code);
    }

    /**
     * @return mixed
     */
    public function getNumberCharCode()
    {
        return $this->numberCharCode;
    }

    /**
     * @param mixed $numberCharCode
     */
    public function setNumberCharCode($numberCharCode): void
    {
        $this->numberCharCode = $numberCharCode;
    }

    /**
     * @return mixed
     */
    public function getCodeSalt()
    {
        return $this->codeSalt;
    }

    /**
     * @param mixed $codeSalt
     */
    public function setCodeSalt($codeSalt): void
    {
        $this->codeSalt = $codeSalt;
    }
}