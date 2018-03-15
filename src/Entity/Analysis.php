<?php

namespace Cas\PageAnalyzer\Entity;

use Cas\PageAnalyzer\Analyzer\AnalyzerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Analysis
 * @package Cas\PageAnalyzer\Entity
 */
class Analysis
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var AnalyzerInterface
     */
    protected $analyzer;

    /**
     * @var
     */
    protected $data;

    /**
     * Analysis constructor.
     * @param AnalyzerInterface $analyzer
     */
    public function __construct(AnalyzerInterface $analyzer)
    {
        $this->analyzer = $analyzer;
    }

    /**
     * @return AnalyzerInterface
     */
    public function getAnalyzer() : AnalyzerInterface
    {
        return $this->analyzer;
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
    public function analyzeResponse() : Analysis
    {
        $this->data = $this->analyzer->analyzeResponse($this->response);

        return $this;
    }

    /**
     * @return array
     */
    public function analyze(string $string) : Analysis
    {
        $this->data = $this->analyzer->analyze($string);

        return $this;
    }

    public function getData() : array
    {
        return $this->data;
    }
}