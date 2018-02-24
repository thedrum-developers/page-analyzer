<?php

namespace Cas\PageAnalyser\Analyser;

use Psr\Http\Message\ResponseInterface;

/**
 * Class LinkPage
 * @package Cas\PageAnalyser\Analyser
 */
class LinkPage extends BaseAnalyser
{
    /**
     * @param string $content
     * @return array
     */
    public function analyse(string $content) : array
    {
        if (!preg_match_all('/<link[^>]*?rel="alternate.*?>/i', $content, $matches)) {
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
