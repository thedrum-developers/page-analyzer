<?php

namespace Cas\PageAnalyser\Analyser;

use Cas\PageAnalyser\Analyser\AnalyserInterface;

class JsonLd implements AnalyserInterface
{
    public function analyse($content)
    {
        if (!preg_match_all('/<script[^>]*?type="application\/ld\+json">(.*?)<\/script>/i', $content, $matches)) {
            return array();
        }

        $data = array();
        foreach ($matches[1] as $match) {
            $extractedData = json_decode($match);

            if (is_object($extractedData) && get_class($extractedData) == 'stdClass') {
                $data[] = json_decode($match, true);
            } elseif (is_array($extractedData)) {
                $extractedData = json_decode($match, true);

                foreach ($extractedData as $extractedDataElement) {
                    $data[] = $extractedDataElement;
                }
            }
        }

        return $data;
    }
}
