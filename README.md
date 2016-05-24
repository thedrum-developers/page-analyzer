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
```
$analyser = new \Cas\PageAnalyser\PageAnalyser();
$analysis = $analyser->fetchAndAnalise('http://insidethe.agency');
```

Analyse local content
```
$content = 'SOME HTML CONTENT';
$analyser = new \Cas\PageAnalyser\PageAnalyser();
$analysis = $analyser->analyse($content);
```

## Custom Analysers

Create the new analyser class
```
namespace App\Analyser;

use Cas\PageAnalyser\Analyser\AnalyserInterface;

class MyCustomAnalyser implements AnalyserInterface
{
    // Return an array of data with the results of the analysis
    public function analyse($content)
    {
        ...
    }
}
```

Set the list of analysers when creating the PageAnalyser.

```
$analysers = array(
    "Cas\PageAnalyser\Analyser\JsonLd",
    "Cas\PageAnalyser\Analyser\MetaData",
    "Cas\PageAnalyser\Analyser\Logo",
    "App\Analyser\MyCustomAnalyser",
);

$analyser = new \Cas\PageAnalyser\PageAnalyser($analysers);
$analysis = $analyser->fetchAndAnalise('http://insidethe.agency');
```

The first 3 are the default enabled analysers but any or all of these
can be omitted.  Simply pass in the list of required analysers to the constructor.
