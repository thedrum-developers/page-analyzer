<?php

namespace Cas\PageAnalyzer\Analyzer;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Canonical
 * @package Cas\PageAnalyzer\Analyzer
 */
class Canonical extends BaseAnalyzer
{
    /**
     * @param ResponseInterface $response
     * @return array
     */
    public function analyzeResponse(ResponseInterface $response) : array
    {
        $content = $this->extractBody($response);

        $canonicalLink = $this->analyze($content);

        if ($canonicalLink) {
            return $canonicalLink;
        }

        // Check for any 301's in the response headers
        $redirects = $response->getHeader(\GuzzleHttp\RedirectMiddleware::HISTORY_HEADER);

        if (!empty($redirects)) {
            return [ end($redirects) ];
        }

        // Return empty array if we've not found a canonical link
        return [];
    }

    /**
     * @param string $content
     * @return array
     */
    public function analyze(string $content) : array
    {
        // Check the page source for a canonical link
        if (preg_match_all('/<link[^>]*?rel=["\']canonical.*?>/i', $content, $matches)) {
            $dom = new \DOMDocument();

            foreach ($matches[0] as $match) {
                $dom->loadHTML('<?xml encoding="UTF-8">' . $match);

                $attributes = array();
                foreach ($dom->getElementsByTagName('link')->item(0)->attributes as $key => $node) {
                    if ($key == 'href') {
                        return [ $node->nodeValue ];
                    }
                }
            }
        }

        // Return empty array if we've not found a canonical link
        return [];
    }
}
