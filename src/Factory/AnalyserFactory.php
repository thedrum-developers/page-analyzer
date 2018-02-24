<?php

namespace Cas\PageAnalyser\Factory;

use Cas\PageAnalyser\Entity\Analysis;
use Cas\PageAnalyser\Manager\AnalyserManager;

/**
 * Class AnalyserFactory
 * @package Cas\PageAnalyser\Factory
 */
class AnalyserFactory
{
    /**
     * @var array
     */
    protected $analyserReferences = array();

    /**
     * @return AnalyserManager
     */
    public function createManager()
    {
        $manager = new AnalyserManager();

        foreach ($this->analyserReferences as $analyserReference) {
            $manager->addAnalyser(new $analyserReference());
        }

        return $manager;
    }

    /**
     * @param string $analyserReference
     * @return $this
     */
    public function addAnalyserReference(string $analyserReference)
    {
        $this->analyserReferences[] = $analyserReference;

        return $this;
    }
}