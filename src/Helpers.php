<?php

namespace Balsama\Query311;

class Helpers
{

    /**
     * For a typical array of `[$date => $value]`'s, converts it into a CSV of the given name.
     *
     * @param array  $array
     * @param string $filename
     */
    public static function convertDateValArrayToCsv(array $array, string $filename)
    {
        $array = self::fillMissingDateArrayKeys($array);
        $array = self::arrayValuesToCounts($array);
        $array = self::includeArrayKeysInArray($array);

        self::csv(['date', 'value'], $array, $filename);
    }

    /**
     * Shifts each top level key of an array of arrays into the row's contained array while preserving top-level keys.
     *
     * @example
     *   Given
     *     [
     *       'a' => 'foo',
     *       'b' => 'bar',
     *     ]
     *   Returns
     *     [
     *       'a' => ['a', 'foo'],
     *       'b' => ['b', 'bar'],
     *     ]
     *
     * @param  array[] | string[] $array
     * @return array[]
     */
    public static function includeArrayKeysInArray(array $array)
    {
        $newArray = [];
        foreach ($array as $key => $row) {
            if (is_array($row)) {
                array_unshift($row, $key);
                $newArray[$key] = $row;
            } elseif (is_string($row) || is_int($row)) {
                $newArray[$key] = [$key, $row];
            } else {
                throw new \InvalidArgumentException('Expected each row in the array to be an array, string, or int.');
            }
        }

        return $newArray;
    }

    /**
     * Writes an array of arrays to a CSV file.
     *
     * @param string[] $headers
     *   The names of the table columns. Pass an empty array if you don't want any headers (e.g. if you're appending to
     *   an existing file.
     * @param array[] $data
     *   Data to write. Each top-level array should contain an array the same length as the $header array.
     * @param string $filename
     * @param bool $append
     *   Whether to append to the file if it exist or overwrite from the beginning of the file.
     * @param string $path
     */
    public static function csv(array $headers, array $data, string $filename, $append = false, $path = 'data/')
    {
        if ($headers && $data) {
            if (count($headers) !== count(reset($data))) {
                throw new \InvalidArgumentException(
                    'The length of the `$header` array must equal the length of each of the arrays in `$data`'
                );
            }
        }

        $mode = ($append) ? 'a' : 'w';

        $fp = fopen($path . $filename, $mode);
        if ($headers) {
            fputcsv($fp, $headers);
        }
        foreach ($data as $datum) {
            fputcsv($fp, $datum);
        }
        fclose($fp);
    }

    /**
     * Given an array keyed by dates, returns an array with any missing date keys filled.
     *
     * @param  array $array
     * @return array $array
     */
    public static function fillMissingDateArrayKeys(array $array)
    {
        if (empty($array)) {
            return [];
        }
        $formatLength = strlen(array_key_first($array));

        switch ($formatLength) {
            case 4:
                $format = 'Y';
                $step = 'year';
                break;
            case 7:
                $format = 'Y-m';
                $step = 'month';
                break;
            case 10:
                $format = 'Y-m-d';
                $step = 'day';
                break;
            default:
                throw new \InvalidArgumentException(
                    'The keys must be dates in one of the following formats: `Y`, `Y-m`, or `Y-m-d`. `'
                    . array_key_first($array)
                    . '` was provided.'
                );
        }

        $start = strtotime(array_key_first($array));
        $current = $start;
        $end = strtotime(array_key_last($array));
        $newArray = [];
        $defaultValue = (is_array(reset($array))) ? [] : 0;
        while ($current < $end) {
            $newArray[date($format, $current)] = $defaultValue;
            $current = strtotime("+1 $step", $current);
        }

        return array_merge($newArray, $array);
    }

    /**
     * Given an array of arrays, returns the count of each second level array while preserving top-level array keys.
     *
     * @param  array[] $array
     * @return array[]
     */
    public static function arrayValuesToCounts($array)
    {
        $newArray = [];
        foreach ($array as $key => $row) {
            $newArray[$key] = count($row);
        }

        return $newArray;
    }

    /**
     * Given an array of arrays keyed by dates, fills each of the arrays with any missing date keys and values based on
     * the earliest start and latest end of all the arrays.
     *
     * @param  array[] $arrays
     * @return array[]
     */
    public static function fillLowerLevelDates($arrays)
    {
        // 1. Find earliest and latest dates in all the arrays.
        foreach ($arrays as $key => $array) {
            $potentialFirsts[] = array_key_first($array);
            $potentialLasts[] = array_key_last($array);

            $keys[] = $key;
        }
        sort($potentialFirsts);
        sort($potentialLasts);
        $start = reset($potentialFirsts);
        $end = end($potentialLasts);

        $i = 0;
        $newArray = [];
        foreach ($arrays as $array) {
            // 2. Plug first and last if not already set.
            if (!array_key_exists($start, $array)) {
                $array = [$start => 0] + $array;
            }
            if (!array_key_exists($end, $array)) {
                $array[$end] = 0;
            }

            // 3. Fill in the gaps.
            $array = self::fillMissingDateArrayKeys($array);

            $newArray[$keys[$i]] = $array;

            $i++;
        }

        return $newArray;
    }

    /**
     * Given an array of arrays keyed by date (with identical numbers of items in each array and the same start and end
     * date), flattens the array into [date, val1, val2, ...].
     *
     * @param  array[] $arrays
     * @return array[]
     */
    public static function flattenMultitermDateCount(array $arrays)
    {
        $newArray = [];
        foreach ($arrays as $array) {
            foreach ($array as $date => $value) {
                $newArray[$date][] = $value;
            }
        }
        $newArray = self::includeArrayKeysInArray($newArray);

        return $newArray;
    }

    public static function getNeighborhoods()
    {
        return [
            'Allston',
            'Back Bay',
            'Bay Village',
            'Beacon Hill',
            'Brighton',
            'Charlestown',
            'Chinatown',
            'Leather District',
            'Dorchester',
            'Downtown',
            'East Boston',
            'Fenway',
            'Kenmore',
            'Hyde Park',
            'Jamaica Plain',
            'Mattapan',
            'Mission Hill',
            'North End',
            'Roslindale',
            'Roxbury',
            'South Boston',
            'South End',
            'West End',
            'West Roxbury',
        ];
    }

    /**
     * Download all images in the provided $reports into the provided folder.
     *
     * @param array[] $reports
     * @param string $path
     * @param string $prefix
     * @param int $i
     */
    public static function downloadImages($reports, $path = 'data/photos/', $prefix = 'photo-', $i = 1)
    {
        foreach ($reports as $report) {
            if (isset($report['attributes']['field_media_url'])) {
                $raw = file_get_contents($report['attributes']['field_media_url']);
                file_put_contents($path . $prefix . $i . '.jpg', $raw);
                $i++;
            }
        }
    }

    /**
     * Justifies and writes the provided text to the provided image resource.
     *
     * @param resource $image
     * @param string $text
     * @param int $left
     * @param int $top
     * @param int $size
     * @param null $textColor
     * @param null $strokeColor
     * @param null $fontFile
     * @param int $maxWidth
     * @param int $minSpacing
     * @param int $lineSpacing
     * @param int $strokeSize
     * @param int $angle
     *
     * @return resource
     *
     * @throws \Exception
     */
    public static function imageTtfTextJustified(
        $image,
        $text,
        $left = 20,
        $top = 50,
        $size = 25,
        $textColor = null,
        $strokeColor = null,
        $fontFile = null,
        $maxWidth = null,
        $minSpacing = 3,
        $lineSpacing = 1,
        $strokeSize = 2,
        $angle = 0
    ) {
        if (!$textColor) {
            $textColor = imagecolorallocate($image, 255, 255, 255);
        }
        if (!$strokeColor) {
            $strokeColor = imagecolorallocate($image, 0, 0, 0);
        }
        if (!$fontFile) {
            // Assumes macOS with SFCompact installed.
            if (!file_exists('/System/Library/Fonts/SFCompact.ttf')) {
                throw new \Exception('You must provide a path to a valid TTF font file.');
            }
            $fontFile = '/System/Library/Fonts/SFCompact.ttf';
        }
        if (!$maxWidth) {
            $maxWidth = (imagesx($image) - (50 + $left));
        }

        $wordWidth = [];
        $lineWidth = [];
        $lineWordCount = [];
        $largest_line_height = 0;
        $lineno = 0;
        $words = explode(' ', $text);
        $wln = 0;
        $lineWidth[$lineno] = 0;
        $lineWordCount[$lineno] = 0;
        $wordText = [];
        foreach ($words as $word) {
            $dimensions = imagettfbbox($size, $angle, $fontFile, $word);
            $line_width = $dimensions[2] - $dimensions[0];
            $line_height = $dimensions[1] - $dimensions[7];
            if ($line_height > $largest_line_height) {
                $largest_line_height = $line_height;
            }
            if (($lineWidth[$lineno] + $line_width + $minSpacing) > $maxWidth) {
                $lineno++;
                $lineWidth[$lineno] = 0;
                $lineWordCount[$lineno] = 0;
                $wln = 0;
            }
            $lineWidth[$lineno] += $line_width + $minSpacing;
            $wordWidth[$lineno][$wln] = $line_width;
            $wordText[$lineno][$wln] = $word;
            $lineWordCount[$lineno]++;
            $wln++;
        }
        for ($ln = 0; $ln <= $lineno; $ln++) {
            $spacing = $minSpacing;

            $x = 0;
            for (
                $w = 0;
                 $w < $lineWordCount[$ln];
                 $w++
            ) {
                $single_word_text = $wordText[$ln][$w];
                self::imagettfstroketext(
                    $image,
                    $single_word_text,
                    $size,
                    $strokeSize,
                    $left + intval($x),
                    $top + $largest_line_height + ($largest_line_height * $ln * $lineSpacing),
                    $textColor,
                    $strokeColor,
                    $fontFile,
                    $angle
                );
                $x += $wordWidth[$ln][$w] + $spacing + $minSpacing;
            }
        }
        return $image;
    }

    /**
     * Writes the provided test to the provided image resource.
     *
     * @param resource $image
     * @param string $text
     * @param int $size
     * @param int $strokeSize
     * @param int $xPosition
     * @param int $yPosition
     * @param null $textColor
     * @param null $strokeColor
     * @param null $fontFile
     * @param int $angle
     *
     * @return resource
     */
    private static function imageTtfStrokeText(
        $image,
        $text,
        $size = 25,
        $strokeSize = 2,
        $xPosition = 20,
        $yPosition = 50,
        $textColor = null,
        $strokeColor = null,
        $fontFile = null,
        $angle = 0
    ) {
        for ($c1 = ($xPosition - abs($strokeSize)); $c1 <= ($xPosition + abs($strokeSize)); $c1++) {
            for ($c2 = ($yPosition - abs($strokeSize)); $c2 <= ($yPosition + abs($strokeSize)); $c2++) {
                imagettftext($image, $size, $angle, $c1, $c2, $strokeColor, $fontFile, $text);
            }
        }
        return imagettftext($image, $size, $angle, $xPosition, $yPosition, $textColor, $fontFile, $text);
    }

    public static function areaFromZip($zip, $geojson): float
    {
        foreach ($geojson as $geozip) {
            if ($geozip->properties->ZIP5 == $zip) {
                $area = ($geozip->properties->ShapeSTArea / 43560);
                if ($area == 0) {
                    $foo = 21;
                }
                return $area;
            }
        }
        throw new \Exception('Could not find zip in geojson file');
    }
}
