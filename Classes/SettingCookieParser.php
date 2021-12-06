<?php

namespace Classes;

class SettingCookieParser
{
    static public function getCookie()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $timeout = 120;
        $dir = $_SERVER['DOCUMENT_ROOT'];

        $cookie_file = $dir . '/cookies/' . md5($_SERVER['HTTP_USER_AGENT']) . '.txt';

        $ch = curl_init("https://www.scopus.com/");
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
        curl_exec($ch);
        curl_close($ch);
    }
}