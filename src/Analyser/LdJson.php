<?php

namespace Cas\PageAnalyser\Analyser;

use Cas\PageAnalyser\Analyser\AnalyserInterface;

class LdJson implements AnalyserInterface
{
    public function analyse($content)
    {
        if (!preg_match_all('/<script[^>]*?type="application\/ld\+json">(.*?)<\/script>/i', $content, $metaMatches)) {
            return array();
        }

        $data = array();
        foreach ($metaMatches[1] as $match) {
            $extractedData = json_decode($match);

            if (get_class($extractedData[0]) == 'stdClass') {
                $extractedData = json_decode($match, true);

                foreach ($extractedData as $extractedDataElement) {
                    $data[] = $extractedDataElement;
                }
            } else {
                $data[] = json_decode($match, true);
            }
        }

        return $data;
    }
}
