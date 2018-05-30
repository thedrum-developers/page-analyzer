<?php

namespace Cas\PageAnalyzer\Manager;

use Cas\PageAnalyzer\Analyzer\AnalyzerInterface;
use Cas\PageAnalyzer\Entity\Analysis;
use Cas\PageAnalyzer\Exception\NoAnalyzersConfiguredException;
use Cas\PageAnalyzer\Factory\AnalyzerFactory;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AnalyzerManager
 * @package Cas\PageAnalyzer
 */
class AnalyzerManager implements AnalyzerManagerInterface
{
    /**
     * @var GuzzleClient
     */
    protected $guzzle;

    protected $factory;

    protected $analysis = [];


    /**
     * AnalyzerManager constructor.
     */
    public function __construct()
    {
        $this->guzzle = new GuzzleClient([
            'allow_redirects' => [
                'track_redirects' => true
            ],
            'headers' => [
                'User-Agent' => 'PageAnalyzer 1.0 (ChrisShennan/PageAnalyzer)'
            ]
        ]);
    }

    /**
     * @param AnalyzerInterface $analyzer
     * @return $this
     */
    public function addAnalyzer(AnalyzerInterface $analyzer)
    {
        $this->analyzers[] = $analyzer;

        return $this;
    }

    /**
     * @param array $analyzers
     * @return $this
     */
    public function addAnalyzers(array $analyzers)
    {
        foreach ($analyzers as $analyzer) {
            $this->analyzers[] = $analyzer;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearAnalyzers()
    {
        $this->analyzers = [];

        return $this;
    }

    /**
     * @param string $url
     * @return array
     * @throws NoAnalyzersConfiguredException
     */
    public function analyze(string $url) : AnalyzerManager
    {
        // Check to make sure we have analyzers configured
        if (count($this->analyzers) === 0) {
            throw new NoAnalyzersConfiguredException();
        }

        // Get the response
        $response = $this->guzzle->get($url);

        // If we don't have a 200 response then return an empty array
        if ($response->getStatusCode() !== 200) {
            return [];
        }

        $analysisCollection = [];

        // Gather all the data from each analyzer
        foreach ($this->analyzers as $analyzer) {
            $analysis = new Analysis($analyzer);
            $analysis->setResponse($response)->analyzeResponse();

            $analysisCollection[get_class($analyzer)] = $analysis;
        }

        // Return all the analysis
        $this->analysis = $analysisCollection;

        return $this;
    }

    public function getAnalysis() : array
    {
        return $this->analysis;
    }

}
