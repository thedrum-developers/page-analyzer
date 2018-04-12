<?php

namespace Cas\PageAnalyzer\Analyzer;

use Psr\Http\Message\ResponseInterface;

/**
 * Class LinkPage
 * @package Cas\PageAnalyzer\Analyzer
 */
class LinkPage extends BaseAnalyzer
{
    /**
     * @param string $content
     * @return array
     */
    public function analyze(string $content) : array
    {
        if (!preg_match_all('/<link[^>]*?rel=["\']alternate.*?>/i', $content, $matches)) {
            return array();
        }

        $data = array();
        $dom = new \DOMDocument();

        foreach ($matches[0] as $match) {
            $dom->loadHTML($match);

            $attributes = array();
            foreach ($dom->getElementsByTagName('link')->item(0)->attributes as $key => $node) {
                $attributes[$key] = $node->nodeValue;
            }

            $data[] = $attributes;
        }

        return $data;
    }
}
