<?php
require 'vendor/autoload.php';

use Pelago\Emogrifier\CssInliner;
use Pelago\Emogrifier\HtmlProcessor\CssToAttributeConverter;
use Pelago\Emogrifier\HtmlProcessor\HtmlPruner;

$html = file_get_contents('source/index.html');
$css = file_get_contents('source/styles.css');


$cssInliner = CssInliner::fromHtml($html)->inlineCss($css);
$domDocument = $cssInliner->getDomDocument();
HtmlPruner::fromDomDocument($domDocument)->removeElementsWithDisplayNone()
    ->removeRedundantClassesAfterCssInlined($cssInliner);
$finalHtml = CssToAttributeConverter::fromDomDocument($domDocument)
    ->convertCssToVisualAttributes()->render();


file_put_contents('dist/index.html', $finalHtml);