<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$useragent = $_SERVER['HTTP_USER_AGENT'];
$timeout = 120;
$dir = $_SERVER['DOCUMENT_ROOT'];


$useragent = $_SERVER['HTTP_USER_AGENT'];
$timeout = 120;
$dir = $_SERVER['DOCUMENT_ROOT'];

$cookie_file = $dir . '/cookies/google' . md5($_SERVER['HTTP_USER_AGENT']) . '.txt';

$ch = curl_init("https://scholar.google.com.ua/citations?user=rtfQ0b8AAAAJ");
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_MAXREDIRS, 100);
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

$dom = curl_exec($ch);

$doc = new DOMDocument();
@$doc->loadHTML($dom);

foreach ($doc->getElementById('gsc_a_b')->childNodes as $item) {
    echo "<pre>";
    //print_r($item->childNodes->item(0)->childNodes->item(0)->nodeValue);
//    print_r($item->childNodes->item(0)->childNodes->item(1)->nodeValue);
    print_r($item->childNodes->item(0)->childNodes->item(2)->nodeValue);
    echo "</pre>";
    echo "<br>";
}

//$classname="gsc_lcl gsc_prf_pnl";
//$finder = new DomXPath($doc);
//$main = $finder->query("//*[contains(@class, '$classname')]");

//
//var_dump($main->item(0));
curl_close($ch);