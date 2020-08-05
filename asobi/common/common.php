<?php
    function gengo($seireki) { 
        if (1912 <= $seireki && $seireki <= 1925) {
            $gengo = '大正';
        }
        if (1926 <= $seireki && $seireki <= 1988) {
            $gengo = '昭和';
        }
        if (1989 <= $seireki && $seireki <= 2018) {
            $gengo = '平成';
        }
        if (2019 <= $seireki) {
            $gengo = '令和';
        }

        return $gengo;
    }
?>