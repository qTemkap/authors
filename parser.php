<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$useragent = $_SERVER['HTTP_USER_AGENT'];
$timeout = 120;
$dir = $_SERVER['DOCUMENT_ROOT'];


function cURL($url){
    $ch =  curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result =  curl_exec($ch);
    curl_close($ch);
    if ($result){
        return $result;
    }else{
        return '';
    }
}

$json_file = cURL("https://scholar.google.com.ua/citations?user=rtfQ0b8AAAAJ");

var_export($json_file);

exit();


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