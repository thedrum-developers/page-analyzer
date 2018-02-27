<?php

namespace Cas\PageAnalyser\Analyser;

use Cas\PageAnalyser\Exception\MethodNotApplicableException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseHeader
 * @package Cas\PageAnalyser\Analyser
 */
class ResponseHeader extends BaseAnalyser
{

    /**
     * @param ResponseInterface $response
     * @return array
     */
    public function analyseResponse(ResponseInterface $response) : array
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
    public function analyse(string $content): array
    {
        throw new MethodNotApplicableException();
    }
}
