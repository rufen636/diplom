<?php

namespace App\Helpers;

/**
 * Конвертация числа в сумму прописью (рубли и копейки) на русском языке.
 */
class NumToStr
{
    protected static array $units = [
        ['копейка', 'копейки', 'копеек'],
        ['рубль', 'рубля', 'рублей'],
    ];

    protected static array $tens = [
        ['', '', ''],
        ['', 'десять', 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'],
        ['', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'],
    ];

    protected static array $teens = [
        'десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать',
        'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать',
    ];

    protected static array $hundreds = [
        '', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять',
    ];

    protected static array $hundredsFeminine = [
        '', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять',
    ];

    public static function rubles(float $amount): string
    {
        $rubles = (int) floor($amount);
        $kopecks = (int) round(($amount - $rubles) * 100);

        $rublesStr = self::numberToWords($rubles, 1);
        $kopecksStr = self::numberToWords($kopecks, 0);

        $rublesWord = self::morph($rubles, self::$units[1]);
        $kopecksWord = self::morph($kopecks, self::$units[0]);

        return trim($rublesStr . ' ' . $rublesWord . ' ' . str_pad((string) $kopecks, 2, '0', STR_PAD_LEFT) . ' ' . $kopecksWord);
    }

    /**
     * Сумма прописью с валютой (для договоров: "1000 (одна тысяча рублей)").
     */
    public static function rublesWords(float $amount): string
    {
        $rubles = (int) floor($amount);
        $rublesStr = self::numberToWords($rubles, 1);
        $rublesWord = self::morph($rubles, self::$units[1]);

        return trim($rublesStr . ' ' . $rublesWord);
    }

    /**
     * Только число прописью без валюты (для "1000 (одна тысяча) рублей").
     */
    public static function amountWordsOnly(float $amount): string
    {
        $rubles = (int) floor($amount);

        return self::numberToWords($rubles, 1);
    }

    protected static function numberToWords(int $number, int $gender = 1): string
    {
        if ($number === 0) {
            return 'ноль';
        }

        $result = [];
        $parts = [
            ['', '', ''],
            ['тысяча', 'тысячи', 'тысяч'],
            ['миллион', 'миллиона', 'миллионов'],
            ['миллиард', 'миллиарда', 'миллиардов'],
        ];

        $padded = str_pad((string) $number, 12, '0', STR_PAD_LEFT);
        $groups = array_map('intval', str_split($padded, 3));

        foreach ($groups as $i => $group) {
            if ($group === 0) {
                continue;
            }

            $level = 3 - $i; // 0=единицы, 1=тысячи, 2=миллионы, 3=миллиарды
            $words = self::triadToWords($group, $level === 1 ? 0 : 1); // тысяча - женский род

            if ($words !== '') {
                $result[] = $words;
                if ($level > 0) {
                    $result[] = self::morph($group, $parts[$level]);
                }
            }
        }

        return implode(' ', $result);
    }

    protected static function triadToWords(int $triad, int $gender = 1): string
    {
        $words = [];
        $h = (int) floor($triad / 100);
        $t = (int) floor(($triad % 100) / 10);
        $u = $triad % 10;

        if ($h > 0) {
            $words[] = self::$tens[2][$h];
        }

        if ($t === 1) {
            $words[] = self::$teens[$u];
        } else {
            if ($t > 0) {
                $words[] = self::$tens[1][$t];
            }
            if ($u > 0) {
                $words[] = $gender === 0 ? self::$hundredsFeminine[$u] : self::$hundreds[$u];
            }
        }

        return implode(' ', $words);
    }

    protected static function morph(int $number, array $forms): string
    {
        $number = abs($number) % 100;
        $n1 = $number % 10;

        if ($number >= 11 && $number <= 19) {
            return $forms[2];
        }
        if ($n1 === 1) {
            return $forms[0];
        }
        if ($n1 >= 2 && $n1 <= 4) {
            return $forms[1];
        }

        return $forms[2];
    }
}
