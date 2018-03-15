<?php

namespace Cas\PageAnalyzer\Factory;

use Cas\PageAnalyzer\Entity\Analysis;
use Cas\PageAnalyzer\Manager\AnalyzerManager;

/**
 * Class AnalyzerFactory
 * @package Cas\PageAnalyzer\Factory
 */
class AnalyzerFactory
{
    /**
     * @var array
     */
    protected $analyzerReferences = array();

    /**
     * @return AnalyzerManager
     */
    public function createManager()
    {
        $manager = new AnalyzerManager();

        foreach ($this->analyzerReferences as $analyzerReference) {
            $manager->addAnalyzer(new $analyzerReference());
        }

        return $manager;
    }

    /**
     * @param string $analyzerReference
     * @return $this
     */
    public function addAnalyzerReference(string $analyzerReference)
    {
        $this->analyzerReferences[] = $analyzerReference;

        return $this;
    }
}