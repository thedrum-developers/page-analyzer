<?php

namespace Cas\PageAnalyser;

use Cas\PageAnalyser\Analyser\AnalyserInterface;
use Cas\PageAnalyser\Exception\NoAnalysersConfiguredException;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AnalyserManager
 * @package Cas\PageAnalyser
 */
class AnalyserManager implements AnalyserManagerInterface
{
    /**
     * @var GuzzleClient
     */
    protected $guzzle;

    /**
     * @var array
     */
    protected $analysers = [];

    /**
     * AnalyserManager constructor.
     */
    public function __construct()
    {
        $this->guzzle = new GuzzleClient(['allow_redirects' => ['track_redirects' => true]]);
    }

    /**
     * @param AnalyserInterface $analyser
     * @return $this
     */
    public function addAnalyser(AnalyserInterface $analyser)
    {
        $this->analysers[] = $analyser;

        return $this;
    }

    /**
     * @param array $analysers
     * @return $this
     */
    public function addAnalysers(array $analysers)
    {
        foreach ($analysers as $analyser) {
            $this->analysers[] = $analyser;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearAnalysers()
    {
        $this->analysers = [];

        return $this;
    }

    /**
     * @param string $url
     * @return array
     * @throws NoAnalysersConfiguredException
     */
    public function analyse(string $url) : array
    {
        // Check to make sure we have analysers configured
        if (count($this->analysers) === 0) {
            throw new NoAnalysersConfiguredException();
        }

        // Get the response
        $response = $this->guzzle->get($url);

        // If we don't have a 200 response then return an empty array
        if ($response->getStatusCode() !== 200) {
            return [];
        }

        $data = [];

        // Gather all the data from each analyser
        foreach ($this->analysers as $analyser) {
            $data['analysers'][] = $analyser->analyseResponse($response);
        }

        // Return all the analysis
        return $data;
    }
}
