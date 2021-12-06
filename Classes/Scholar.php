<?php

namespace Classes;

require_once "Classes/Interfaces/PlatformsInterface.php";

use Classes\Interfaces\PlatformsInterface;
use DOMDocument;

class Scholar implements PlatformsInterface
{
    public $posts = [];
    public $resultCurl;

    public function sendCurl($url, $params = array())
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $timeout = 120;
        $dir = $_SERVER['DOCUMENT_ROOT'];

        $cookie_file = $dir . '/cookies/google' . md5($_SERVER['HTTP_USER_AGENT']) . '.txt';

        $ch = curl_init($url);
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

        $this->resultCurl = curl_exec($ch);

        curl_close($ch);

        return $this;
    }

    public function getPosts()
    {
        if (!empty($this->resultCurl)) {
            $doc = new DOMDocument();
            @$doc->loadHTML($this->resultCurl);

            foreach ($doc->getElementById('gsc_a_b')->childNodes as $item) {
                $post['title'] = $item->childNodes->item(0)->childNodes->item(0)->nodeValue;
                $post['authors'] = $item->childNodes->item(0)->childNodes->item(1)->nodeValue;
                $post['source'] = $item->childNodes->item(0)->childNodes->item(2)->nodeValue;
                array_push($this->posts, $post);
            }

            return json_encode(['posts' => $this->posts]);
        } else {
            return "";
        }
    }
}