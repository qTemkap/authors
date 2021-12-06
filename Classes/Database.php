<?php

    namespace Classes;

    class Database
    {
        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $table = "articles";

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