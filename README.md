# Page Analyzer

A simple, extensible page analyzer written in PHP.

Analyzes HTML markup and extracts common attributes such as

 - Meta Tags including OpenGraph tags, Twitter Cards etc
 - JSON-LD
 - Apple Icons / favicon
 - Canonical references
 - Response headers
 - RSS / XML feeds (link alternative)

Easily extensible by adding your own custom analyzers.

## Installation
```
composer require chrisshennan/page-analyzer dev-master
```

## Basic Usage

Analyze a live page

Set the list of analyzers when creating the PageAnalyzer.

```
$loader = require __DIR__.'/vendor/autoload.php';

$url ='https://shoutabout.it';

$analyzerFactory = new \Cas\PageAnalyzer\Factory\AnalyzerFactory();
$analyzerFactory->addAnalyzerReference('\Cas\PageAnalyzer\Analyzer\MetaData');
$analyzerFactory->addAnalyzerReference('\Cas\PageAnalyzer\Analyzer\Logo');

$analyzerManager = $analyzerFactory->createManager();
$analysisCollection = $analyzerManager->analyze($url)->getAnalysis();

$data = [];

foreach ($analysisCollection as $analyzer => $analysis) {
    $data[$analyzer] = $analysis->getData();
}

...

```

## Custom Analyzers

Create the new analyzer class
```
namespace App\Analyzer;

use Cas\PageAnalyzer\Analyzer\BaseAnalyzer;

class MyCustomAnalyzer extends BaseAnalyzer
{
    public function analyze(string $content) : array
    {
        ...
    }
}
```

Add the analyzers to the list of analyzers

```
$loader = require __DIR__.'/vendor/autoload.php';

$url ='https://shoutabout.it';

$analyzerFactory = new \Cas\PageAnalyzer\Factory\AnalyzerFactory();
$analyzerFactory->addAnalyzerReference('\Cas\PageAnalyzer\Analyzer\MetaData');
$analyzerFactory->addAnalyzerReference('\Cas\PageAnalyzer\Analyzer\Logo');
$analyzerFactory->addAnalyzerReference('\App\Analyzer\MyCustomAnalyzer');

$analyzerManager = $analyzerFactory->createManager();
$analysisCollection = $analyzerManager->analyze($url)->getAnalysis();

$data = [];

foreach ($analysisCollection as $analyzer => $analysis) {
    $data[$analyzer] = $analysis->getData();
}

...

```