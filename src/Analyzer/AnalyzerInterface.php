<?php

namespace Cas\PageAnalyzer\Analyzer;

use Psr\Http\Message\ResponseInterface;

interface AnalyzerInterface
{
    public function analyzeResponse(ResponseInterface $response) : array;
    public function analyze(string $content) : array ;
}
