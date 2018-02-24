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
        return $response->getHeaders();
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
