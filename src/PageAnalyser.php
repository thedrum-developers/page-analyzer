<?php

namespace Cas\PageAnalyser;

use GuzzleHttp\Client as GuzzleClient;

class PageAnalyser
{
    protected $guzzle;
    protected $analysers = array();

    public function __construct($analysers = array())
    {
        $this->guzzle = new GuzzleClient();

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

    public function fetchAndAnalise($url)
    {
        try {
            $response = $this->guzzle->get($url);

            $data = array();
            if ($response->getStatusCode() == 200) {
                $data = $this->analyse($response->getBody(), $url);
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
            "Cas\PageAnalyser\Analyser\Logo",
        ]);
    }
}
