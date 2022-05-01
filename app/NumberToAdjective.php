<?php namespace App;

class NumberToAdjective {

    const INITIAL = [
        1 => 'first',
        2 => 'second',
        3 => 'third',
        4 => 'fourth',
        5 => 'fifth',
        6 => 'sixth',
        7 => 'seventh',
        8 => 'eighth',
        9 => 'ninth',
        10 => 'tenth',
        11 => 'eleventh',
        12 => 'twelfth',
        13 => 'thirteenth',
        14 => 'fourteenth',
        15 => 'fifteenth',
        16 => 'sixteenth',
        17 => 'seventeenth',
        18 => 'eighteenth',
        19 => 'nineteenth',
    ];

    const TEN_ADJECTIVES = [
        20 => 'twentieth',
        30 => 'thirtieth',
        40 => 'fortieth',
        50 => 'fiftieth',
        60 => 'sixtieth',
        70 => 'seventieth',
        80 => 'eightieth',
        90 => 'ninetieth',
        100 => 'hundredth',
    ];

    const TENS = [
        20 => 'twenty',
        30 => 'thirty',
        40 => 'forty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
        100 => 'one hundred',
    ];

    public static function convert(int $number): string
    {
        if ($number < 20) return self::INITIAL[$number];

        $remainder = $number % 10;

        if ($number <= 100 && $remainder === 0) return self::TEN_ADJECTIVES[$number];

        if ($number > 100) return $number . self::getOrdinal($number);

        $ten = $number - $remainder;

        return self::TENS[$ten] . '-' . self::INITIAL[$remainder];
    }

    private static function getOrdinal(int $number): string
    {
        $num = $number % 100;

        if($num < 11 || $num > 13){
            switch($num % 10){
                case 1: return 'st';
                case 2: return 'nd';
                case 3: return 'rd';
            }
        }

        return 'th';
    }

}
