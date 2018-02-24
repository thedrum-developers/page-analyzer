# Page Analyser

A simple, extensible page analyser written in PHP.

Analyses HTML markup and extracts common attributes such as

 - Meta Tags including OpenGraph tags, Twitter Cards etc
 - JSON-LD
 - Apple Icons / favicon

Easily extensible by adding your own custom analysers.

## Installation
```
composer require chrisshennan/page-analyser dev-master
```

## Basic Usage

Analyse a live page

Set the list of analysers when creating the PageAnalyser.

```
$loader = require __DIR__.'/vendor/autoload.php';

$url ='https://shoutabout.it';

$analyserFactory = new \Cas\PageAnalyser\Factory\AnalyserFactory();
$analyserFactory->addAnalyserReference('\Cas\PageAnalyser\Analyser\MetaData');
$analyserFactory->addAnalyserReference('\Cas\PageAnalyser\Analyser\Logo');

$analyserManager = $analyserFactory->createManager();
$data = $analyserManager->analyse($url);
```

Analyse local content
```
???
```

## Custom Analysers

Create the new analyser class
```
namespace App\Analyser;

use Cas\PageAnalyser\Analyser\BaseAnalyser;

class MyCustomAnalyser extends BaseAnalyser
{
    public function analyse(string $content) : array
    {
        ...
    }
}
```

Add the analysers to the list of analysers
```
$loader = require __DIR__.'/vendor/autoload.php';

$url ='https://shoutabout.it';

$analyserFactory = new \Cas\PageAnalyser\Factory\AnalyserFactory();
$analyserFactory->addAnalyserReference('\Cas\PageAnalyser\Analyser\MetaData');
$analyserFactory->addAnalyserReference('\Cas\PageAnalyser\Analyser\Logo');
$analyserFactory->addAnalyserReference('\App\Analyser\MyCustomAnalyser');

$analyserManager = $analyserFactory->createManager();
$data = $analyserManager->analyse($url);
```
