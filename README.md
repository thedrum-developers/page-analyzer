# Page Analyser

A simple, extendable page analyser written in PHP

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
