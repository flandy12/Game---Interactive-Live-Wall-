<?php

function censor_text(string $text): string
{
    // Normalisasi badwords SEKALI
    $badWords = array_flip(
        array_map('normalize_badword', config('badwords', []))
    );

    return preg_replace_callback(
        '/([a-zA-Z0-9@!$|]+)([^a-zA-Z0-9@!$|]*)/u',
        function ($matches) use ($badWords) {
            $word = $matches[1];        // kata
            $punct = $matches[2] ?? ''; // tanda baca

            $clean = normalize_badword($word);

            if (isset($badWords[$clean])) {
                return str_repeat('*', mb_strlen($word)) . $punct;
            }

            return $word . $punct;
        },
        $text
    );
}


/**
 * Normalisasi kata (Sudah Benar)
 */
function normalize_badword($string)
{
    $string = strtolower($string);

    $map = [
        '4' => 'a',
        '@' => 'a',
        '3' => 'e',
        '1' => 'i',
        '!' => 'i',
        '|' => 'i',
        '0' => 'o',
        '5' => 's',
        '$' => 's',
        '7' => 't',
        '8' => 'b',
        'v' => 'u'
    ];
    $string = strtr($string, $map);
    $string = preg_replace('/[^a-z]/', '', $string);
    $string = preg_replace('/(.)\1+/', '$1', $string);

    return $string;
}
