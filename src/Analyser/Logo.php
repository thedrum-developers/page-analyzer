<?php

namespace Cas\PageAnalyser\Analyser;

use Cas\PageAnalyser\Analyser\AnalyserInterface;

class Logo implements AnalyserInterface
{
    public function analyse($content)
    {
        if (!preg_match_all('/<link[^>]*?rel="(apple-touch-icon|icon).*?>/i', $content, $matches)) {
            return array();
        }

        $logos = array();
        $dom = new \DOMDocument();

        foreach ($matches[0] as $match) {
            $dom->loadHTML($match);
            $src = $dom->getElementsByTagName('link')->item(0)->getAttribute('href');
            $size = $dom->getElementsByTagName('link')->item(0)->getAttribute('sizes');

            if (substr($src, -4) == '.ico') {
                $size = 'favicon';
            }
            $size = explode('x', $size);

            $logos[$size[0]] = $src;
        }

        krsort($logos);

        return $logos;
    }
}
