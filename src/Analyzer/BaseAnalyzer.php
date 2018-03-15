<?php

namespace Cas\PageAnalyzer\Analyzer;

use Cas\PageAnalyzer\Analyzer\AnalyzerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseAnalyzer
 * @package Cas\PageAnalyzer\Analyzer
 */
abstract class BaseAnalyzer implements AnalyzerInterface
{
    /**
     * @param ResponseInterface $response
     * @return array
     */
    public function analyzeResponse(ResponseInterface $response) : array
    {
        $content = $this->extractBody($response);

        return $this->analyze($content);
    }

    /**
     * @param ResponseInterface $response
     * @return string
     */
    protected function extractBody(ResponseInterface $response) : string
    {
        $replacements = $this->getCleanupList();
        
        $content = $response->getBody();

        $content = str_replace(array_keys($replacements), $replacements, $content);

        return $content;
    }

    protected function getCleanupList()
    {
        return [
            "\r\n"  => '',
            "\n"    => '',
        ];
    }
}
