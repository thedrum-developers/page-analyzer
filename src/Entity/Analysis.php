<?php

namespace Cas\PageAnalyser\Entity;

use Cas\PageAnalyser\Analyser\AnalyserInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Analysis
 * @package Cas\PageAnalyser\Entity
 */
class Analysis
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var AnalyserInterface
     */
    protected $analyser;

    /**
     * @var
     */
    protected $data;

    /**
     * Analysis constructor.
     * @param AnalyserInterface $analyser
     */
    public function __construct(AnalyserInterface $analyser)
    {
        $this->analyser = $analyser;
    }

    /**
     * @return AnalyserInterface
     */
    public function getAnalyser() : AnalyserInterface
    {
        return $this->analyser;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse() : ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     * @return Analysis
     */
    public function setResponse(ResponseInterface $response) : Analysis
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return array
     */
    public function analyseResponse() : Analysis
    {
        $this->data = $this->analyser->analyseResponse($this->response);

        return $this;
    }

    /**
     * @return array
     */
    public function analyse(string $string) : Analysis
    {
        $this->data = $this->analyser->analyse($string);

        return $this;
    }

    public function getData() : array
    {
        return $this->data;
    }
}