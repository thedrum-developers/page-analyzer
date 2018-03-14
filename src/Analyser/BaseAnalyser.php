<?php

namespace Cas\PageAnalyser\Analyser;

use Cas\PageAnalyser\Analyser\AnalyserInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseAnalyser
 * @package Cas\PageAnalyser\Analyser
 */
abstract class BaseAnalyser implements AnalyserInterface
{
    /**
     * @param ResponseInterface $response
     * @return array
     */
    public function analyseResponse(ResponseInterface $response) : array
    {
        $content = $this->extractBody($response);

        return $this->analyse($content);
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
