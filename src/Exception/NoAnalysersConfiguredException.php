<?php

namespace Cas\PageAnalyser\Exception;

class NoAnalysersConfiguredException extends \Exception
{
    protected $message = 'No analysers have been configured';
}