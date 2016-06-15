<?php

namespace Cas\PageAnalyser\Analyser;

use Cas\PageAnalyser\Analyser\AnalyserInterface;

class LinkPage implements AnalyserInterface
{
    public function analyse($content)
    {
        if (!preg_match_all('/<link[^>]*?rel="(canonical|alternate).*?>/i', $content, $matches)) {
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
