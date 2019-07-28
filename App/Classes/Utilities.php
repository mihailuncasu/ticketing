<?php

class Utilities {
    static function generateReference ($references) {
        $generated = true;
        do {
            $month = mt_rand(1, 12);
            $year= mt_rand(1000, date("Y"));
            $referenceGenerated = $year . '-' . $month;
            $generated = array_search($referenceGenerated, $references);
        } while ($generated);
        $date = new DateTime($referenceGenerated);
        return $date->format('m-Y');
    }
}