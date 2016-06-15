<?php

namespace Cas\PageAnalyser;

use GuzzleHttp\Client as GuzzleClient;

class PageAnalyser implements PageAnalyserInterface
{
    protected $guzzle;
    protected $analysers = array();

    public function __construct($analysers = array())
    {
        $this->guzzle = new GuzzleClient(['allow_redirects' => ['track_redirects' => true]]);

        if ($analysers) {
            $this->setAnalysers($analysers);
        } else {
            $this->setDefaultAnalysers();
        }
    }

    public function setAnalysers(array $analysers)
    {
        $this->analysers = $analysers;
    }

    public function analyse($content)
    {
        $content = str_replace("\n", "", $content);

        $data = array();

        foreach ($this->analysers as $analyserClass) {
            $analyser = new $analyserClass();
            $data['content'][$analyserClass] = $analyser->analyse($content);
        }

        return $data;
    }

    public function fetchAndAnalise($url, $followCanonical = false)
    {
        try {
            $response = $this->guzzle->get($url);

            $data = array();
            if ($response->getStatusCode() == 200) {
                $data = $this->analyse($response->getBody(), $url);
                $data['effectiveUrl'] = $url;

                // Check for a canonical reference
                if (isset($data['content']['Cas\PageAnalyser\Analyser\LinkPage'])) {
                    foreach ($data['content']['Cas\PageAnalyser\Analyser\LinkPage'] as $link) {
                        if ($link['rel'] == 'canonical') {
                            $data['effectiveUrl'] = $link['href'];
                        }
                    }
                } else {
                    // Check for any 301's
                    $redirects = $response->getHeader(\GuzzleHttp\RedirectMiddleware::HISTORY_HEADER);
                    if (count($redirects)) {
                        $data['effectiveUrl'] = end($redirects);
                    }
                }

                $data['headers'] = $response->getHeaders();
            }

            return $data;
        } catch (\Exception $e) {
            return array();
        }
    }

    protected function setDefaultAnalysers()
    {
        $this->setAnalysers([
            "Cas\PageAnalyser\Analyser\JsonLd",
            "Cas\PageAnalyser\Analyser\MetaData",
            "Cas\PageAnalyser\Analyser\LinkPage",
            "Cas\PageAnalyser\Analyser\Logo",
        ]);
    }
}
