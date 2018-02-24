<?php

namespace Cas\PageAnalyser\Analyser;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Logo
 * @package Cas\PageAnalyser\Analyser
 */
class Logo extends BaseAnalyser
{
    /**
     * @param string $content
     * @return array
     */
    public function analyse(string $content) : array
    {
        if (!preg_match_all('/<link[^>]*?rel="(apple-touch-icon|icon).*?>/i', $content, $matches)) {
            return array();
        }

        $logos = array();
        $dom = new \DOMDocument();

        foreach ($matches[0] as $match) {
            $dom->loadHTML($match);
            $src = $dom->getElementsByTagName('link')->item(0)->getAttribute('href');
            $rel = $dom->getElementsByTagName('link')->item(0)->getAttribute('rel');
            $size = $dom->getElementsByTagName('link')->item(0)->getAttribute('sizes');

            if (substr($src, -4) == '.ico') {
                $size = 'favicon';
            }
            $size = explode('x', $size);

            $logos[$rel][$size[0]] = $src;
        }

        krsort($logos);

        return $logos;
    }
}
