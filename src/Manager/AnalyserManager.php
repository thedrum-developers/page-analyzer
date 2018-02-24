<?php

namespace Cas\PageAnalyser\Manager;

use Cas\PageAnalyser\Analyser\AnalyserInterface;
use Cas\PageAnalyser\Entity\Analysis;
use Cas\PageAnalyser\Exception\NoAnalysersConfiguredException;
use Cas\PageAnalyser\Factory\AnalyserFactory;
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


    protected $factory;


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
            $analysis = new Analysis($analyser);
            $analysis->setResponse($response)->analyseResponse();

            $data[] = $analysis;
        }

        // Return all the analysis
        return $data;
    }
}
