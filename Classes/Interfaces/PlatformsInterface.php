<?php

namespace Classes\Interfaces;

interface PlatformsInterface
{
    public function sendCurl($url, $params = null);
    public function getPosts();

}