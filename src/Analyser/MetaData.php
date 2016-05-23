<?php

namespace Cas\PageAnalyser\Analyser;

use Cas\PageAnalyser\Analyser\AnalyserInterface;

class MetaData implements AnalyserInterface
{
    public function analyse($content)
    {
        if (!preg_match_all('/<meta[^>]*?(name|property).*?>/i', $content, $metaMatches)) {
            return false;
        }

        $data = array();
        $dom = new \DOMDocument();

        foreach ($metaMatches[0] as $index => $match) {
            $dom->loadHTML($match);

            $name = $dom->getElementsByTagName('meta')->item(0)->getAttribute($metaMatches[1][$index]);
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
