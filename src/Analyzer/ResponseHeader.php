<?php

namespace Cas\PageAnalyzer\Analyzer;

use Cas\PageAnalyzer\Exception\MethodNotApplicableException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseHeader
 * @package Cas\PageAnalyzer\Analyzer
 */
class ResponseHeader extends BaseAnalyzer
{

    /**
     * @param ResponseInterface $response
     * @return array
     */
    public function analyzeResponse(ResponseInterface $response) : array
    {
        // Response headers are case insensitive so lower case them for consistency.
        // See: https://www.w3.org/Protocols/rfc2616/rfc2616-sec4.html#sec4.2

        $headers = array_change_key_case($response->getHeaders(), CASE_LOWER);
        return $headers;
    }

    /**
     * @param string $content
     * @return array
     * @throws MethodNotApplicableException
     */
    public function analyze(string $content): array
    {
        throw new MethodNotApplicableException();
    }
}
