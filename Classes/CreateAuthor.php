<?php

namespace Classes;

use Classes\Database;

class CreateAuthor
{
    public $authors = [];

    public function __construct()
    {
        $this->authors = [
            [
                "name" => 'Бреславський Дмитро Васильович',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=6506478274',
                "scholat" => 'https://scholar.google.com.ua/citations?user=rtfQ0b8AAAAJ',
            ],
            [
                "name" => 'Андрєєв Юрій Михайлович',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=10043594600',
                "scholat" => 'https://scholar.google.com.ua/citations?user=VIeykqwAAAAJ',
            ],
            [
                "name" => 'Кортунов Вячеслав Іванович',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=6602260634',
                "scholat" => '-',
            ],
            [
                "name" => 'Морачковський Олег Костянтинович',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=6602294185',
                "scholat" => 'https://scholar.google.com/citations?hl=ru&user=-_rWFokAAAAJ',
            ],
            [
                "name" => 'Плаксій Юрій Андрійович',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=56395380500',
                "scholat" => 'https://scholar.google.com.ua/citations?user=Mdrx_y4AAAAJ',
            ],
            [
                "name" => 'Успенський Валерій Борисович',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=55768670200',
                "scholat" => 'https://scholar.google.com/citations?hl=ru&user=mN_6uBoAAAAJ',
            ],
            [
                "name" => 'Татарінова Оксана Андріївна',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=25628931200',
                "scholat" => 'https://scholar.google.com.ua/citations?user=H-vWDmIAAAAJ',
            ],
            [
                "name" => 'Багмут Іван Олександрович',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=55012783800',
                "scholat" => '-',
            ],
            [
                "name" => 'Іванченко Ксенія Вікторівна',
                "scopus" => '-',
                "scholat" => 'https://scholar.google.com/citations?hl=ru&user=C7IVuUMAAAAJ',
            ],
            [
                "name" => 'Мєтєльов Володимир Олександрович',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=57212495777',
                "scholat" => 'https://scholar.google.com.ua/citations?hl=ru&view_op=list_works&gmla=AJsN-%20F6J7RPqj2akizqvdYFLpsGGc9D6SKV4bAlTz7DuaxUQ6GRRMVuj-%20wKcvrMaAYhOyXwKcTVrRsqCQfTKDEq1NBIaBmkPDULSyVShXdJl8HuAxo%20gZKq4NyMp_zRz_41qsFByVTQdw&user=zTZumIcAAAAJ',
            ],
            [
                "name" => 'Некрасова Марія Володимирівна',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=57194454095',
                "scholat" => 'https://scholar.google.com.ua/citations?user=QR4TIcgAAAAJ',
            ],
            [
                "name" => 'Чистіліна Ганна Вікторівна',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=6504039710',
                "scholat" => '-',
            ],
            [
                "name" => 'Марусенко Олексій Миколайович',
                "scopus" => 'https://www.scopus.com/authid/detail.uri?authorId=57214220805',
                "scholat" => '-',
            ],
            [
                "name" => 'Фесюков Олексій Володимирович',
                "scopus" => '-',
                "scholat" => '-',
            ],
            [
                "name" => 'Горелова Світлана Олександрівна',
                "scopus" => '-',
                "scholat" => '-',
            ],
            [
                "name" => 'Малько Ігор Іванович',
                "scopus" => '-',
                "scholat" => '-',
            ],
            [
                "name" => 'Сироватченко Ніна Олексіївна',
                "scopus" => '-',
                "scholat" => '-',
            ],
        ];
    }

    public function create()
    {
        $db = new Database();
        foreach ($this->authors as $item) {
            $author = [];
            $author['name'] = $item['name'];

            $nameArray = explode(' ', $item['name']);
            $author['short_name'] = $nameArray[0]." ".mb_substr($nameArray[1], 0, 1).".".mb_substr($nameArray[2], 0, 1).".";
            $author['login'] = $this->randomString(10);
            $author['password'] = $this->randomString(15);
            $author['link_scopus'] = (!empty($item['scopus']) && $item['scopus'] != "-")?$item['scopus'] : "null";
            $author['link_scholar'] = (!empty($item['scholat']) && $item['scholat'] != "-")?$item['scholat'] : "null";

            $strQuery = "INSERT INTO `users` (`name`, `short_name`, `login`, `password`, `link_scopus`, `link_scholar`)
                VALUES ("."'".implode ( "', '", $author)."'".")";

            echo $db->insert($strQuery);
        }
    }

    function randomString($lenght) {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $lenght; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}