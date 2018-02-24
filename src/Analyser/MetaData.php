<?php

namespace Cas\PageAnalyser\Analyser;

use Psr\Http\Message\ResponseInterface;

/**
 * Class MetaData
 * @package Cas\PageAnalyser\Analyser
 */
class MetaData extends BaseAnalyser
{
    /**
     * @param string $content
     * @return array
     */
    public function analyse(string $content) : array
    {
        if (!preg_match_all('/<meta[^>]*?(name|property).*?>/i', $content, $matches)) {
            return array();
        }

        $data = array();
        $dom = new \DOMDocument();

        foreach ($matches[0] as $index => $match) {
            $dom->loadHTML($match);

            $name = $dom->getElementsByTagName('meta')->item(0)->getAttribute($matches[1][$index]);
            $content = $dom->getElementsByTagName('meta')->item(0)->getAttribute('content');

            $nameParts = explode(':', $name);

            if (count($nameParts) == 1) {
                $data[$name] = $content;
            } else {
                $data[$nameParts[0]][$name] = $content;
            }
        }

        return $data;
    }
}
