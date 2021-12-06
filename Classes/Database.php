<?php

    namespace Classes;

    class Database
    {
        private $servername = "eu-cdbr-west-01.cleardb.com";
        private $username = "b37ad2ab8d073f";
        private $password = "b5617e9a";
        private $table = "heroku_faf106e3aa7606b";

        public $DB;

        public function __construct()
        {
            $this->DB = mysqli_connect($this->servername, $this->username, $this->password, $this->table);
        }

        public function query($query_str)
        {
            $query = mysqli_query($this->DB, $query_str);

            return mysqli_fetch_assoc($query);
        }

        public function queryList($query_str)
        {
            $query = mysqli_query($this->DB, $query_str);

            $rows = [];
            while ($row = mysqli_fetch_assoc($query)) {
                array_push($rows, $row);
            }
            return $rows;
        }

        public function insert($query_str)
        {
            if (mysqli_query($this->DB, $query_str)) {
                return true;
            } else {
                return false;
            }
        }

    }