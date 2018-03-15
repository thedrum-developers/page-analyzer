<?php

namespace Cas\PageAnalyzer\Exception;

class NoAnalyzersConfiguredException extends \Exception
{
    protected $message = 'No analyzers have been configured';
}