<?php

namespace Classes;

use Classes\Interfaces\PlatformsInterface;
use Classes\SettingCookieParser;

class Scopus implements PlatformsInterface
{
    public $posts = [];
    public $resultCurl;
    public $url;
    public $params = [];

    public function sendCurl($url, $params = array())
    {
        $this->params = $params;
        $this->url = $url;
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $timeout = 120;
        $dir = $_SERVER['DOCUMENT_ROOT'];
        $cookie_file = $dir . '/cookies/' . md5($_SERVER['HTTP_USER_AGENT']) . '.txt';

        $ch = curl_init($this->setUrl($url));
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
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

    public function setUrl($url)
    {
        $authorLink = parse_url($url);
        $paramsString = $authorLink['query'];
        $paramsArray = explode("=", $paramsString);
        $authorId = $paramsArray[1];
        return "https://www.scopus.com/api/documents/search/preview?sort=plf-f&itemcount=10&authorid=" . $authorId;
    }

    public function getPosts()
    {
        if (!empty($this->resultCurl)) {
            $response = json_decode($this->resultCurl);

            if (!isset($response->items)) {
                if(isset($this->params['cookies'])) {
                    return "";
                }
                SettingCookieParser::getCookie();

                return "cookies";
            }

            foreach ($response->items as $item) {
                $post['type'] = $item->documentType;
                $post['title'] = $item->titles[0];
                $post['source'] = $item->source->title;
                $authorsArray = [];

                foreach ($item->authors as $author) {
                    array_push($authorsArray, $author->preferredName->full);
                }

                $post['authors'] = implode(', ', $authorsArray);
                array_push($this->posts, $post);
            }

            return json_encode(['posts' => $this->posts]);
        } else {
            return "";
        }
    }


}