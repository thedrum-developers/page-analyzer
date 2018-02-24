<?php

namespace Cas\PageAnalyser\Analyser;

use Psr\Http\Message\ResponseInterface;

interface AnalyserInterface
{
    public function analyseResponse(ResponseInterface $response) : array;
    public function analyse(string $content) : array ;
}
