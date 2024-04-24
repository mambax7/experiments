<?php declare(strict_types=1);
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Xmf;

/**
 * @category  Xmf\Utility
 * @package   Xmf
 * @author    Michael Beck <mambax7@gmail.com>
 * @copyright 2023 XOOPS Project (https://xoops.org)
 * @license   GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */
class Utility
{
    public static function arrayGet(array $array, string $key, mixed $default = null): mixed
    {
        return $array[$key] ?? $default;
    }

    public static function arrayPluck(array $array, string $key): array
    {
        return array_column($array, $key);
    }

    public static function arrayRemoveEmpty(array $array): array
    {
        return array_filter($array);
    }

    public static function arrayFlatten(array $array): array
    {
        return iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($array)), false);
    }

    public static function arrayZip(array $keys, array $values): array
    {
        return array_combine($keys, $values);
    }

    public static function arrayShuffleAssoc(array $array): array
    {
        $keys = array_keys($array);
        shuffle($keys);
        return array_merge(array_flip($keys), $array);
    }

    public static function arrayRandom(array $array, int $num = 1): mixed
    {
        $keys = array_rand($array, $num);
        return is_array($keys) ? array_intersect_key($array, array_flip($keys)) : $array[$keys];
    }

    public static function arrayIsAssociative(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }

    public static function arrayFirst(array $array): mixed
    {
        return reset($array);
    }

    public static function arrayLast(array $array): mixed
    {
        return end($array);
    }

    public static function arrayGetKey(array $array, mixed $value): int|string|false
    {
        return array_search($value, $array, true);
    }

    public static function arrayInsert(array $array, int $position, array $insertArray): array
    {
        return array_merge(array_slice($array, 0, $position), $insertArray, array_slice($array, $position));
    }

    public static function arrayMoveKey(array $array, int|string $key, int $position): array
    {
        if (!array_key_exists($key, $array)) {
            return $array;
        }
        $item = [$key => $array[$key]];
        unset($array[$key]);
        return array_merge(array_slice($array, 0, $position), $item, array_slice($array, $position));
    }

    public static function arrayOnly(array $array, array $keys): array
    {
        return array_intersect_key($array, array_flip($keys));
    }

    public static function arrayExcept(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }

    public static function arrayRenameKey(array &$array, string $oldKey, string $newKey): void
    {
        if (array_key_exists($oldKey, $array)) {
            $array[$newKey] = $array[$oldKey];
            unset($array[$oldKey]);
        }
    }

    public static function arrayMapKeys(array $array, callable $callback): array
    {
        $keys = array_map($callback, array_keys($array));
        return array_combine($keys, $array);
    }

    public static function arrayMapAssoc(array $array, callable $callback): array
    {
        return array_map($callback, $array, array_keys($array));
    }

    public static function arrayMultiply(array $array, float $multiplier): array
    {
        return array_map(fn($value) => $value * $multiplier, $array);
    }

    public static function arrayPartition(array $array, callable $predicate): array
    {
        $matches = array_filter($array, $predicate);
        $nonMatches = array_diff_key($array, $matches);
        return [$matches, $nonMatches];
    }

    public static function arrayReduceAssoc(array $array, callable $callback, mixed $initial = null): mixed
    {
        return array_reduce(array_keys($array), fn($carry, $key) => $callback($carry, $key, $array[$key]), $initial);
    }

    public static function arrayTrimValues(array $array): array
    {
        return array_map('trim', $array);
    }

    public static function arrayUniqueAssoc(array $array): array
    {
        $serialized = array_map('serialize', $array);
        $unique = array_unique($serialized);
        return array_intersect_key($array, array_flip($unique));
    }

    public static function arrayValuesAssoc(array $array): array
    {
        return array_map('array_values', $array);
    }

    public static function arrayKeysMulti(array $array): array
    {
        $result = [];
        array_walk_recursive($array, function ($value, $key) use (&$result) {
            $result[] = $key;
        });
        return array_unique($result);
    }

    public static function arrayValuesMulti(array $array): array
    {
        $result = [];
        array_walk_recursive($array, function ($value) use (&$result) {
            $result[] = $value;
        });
        return $result;
    }

    public static function arrayReplaceRecursive(array $array, array ...$arrays): array
    {
        foreach ($arrays as $arr) {
            foreach ($arr as $key => $value) {
                if (is_array($value) && isset($array[$key]) && is_array($array[$key])) {
                    $array[$key] = self::arrayReplaceRecursive($array[$key], $value);
                } else {
                    $array[$key] = $value;
                }
            }
        }
        return $array;
    }

    public static function arrayPadAssoc(array $array, int $size, mixed $value): array
    {
        $result = $array + array_fill(0, $size, $value);
        return array_slice($result, 0, $size, true);
    }

    public static function arraySliceAssoc(array $array, int $offset, int $length = null, bool $preserveKeys = true): array
    {
        return array_slice($array, $offset, $length, $preserveKeys);
    }

    public static function arrayWalkRecursiveAssoc(array &$array, callable $callback): void
    {
        array_walk_recursive($array, $callback);
    }

    public static function arrayKeyExistsRecursive(array $keys, array $array): bool
    {
        foreach ($keys as $key) {
            if (!isset($array[$key])) {
                return false;
            }
            $array = $array[$key];
        }
        return true;
    }

    public static function arraySetRecursive(array &$array, array $keys, mixed $value): void
    {
        foreach ($keys as $key) {
            $array = &$array[$key] ??= [];
        }
        $array = $value;
    }

    public static function arrayUnsetRecursive(array &$array, array $keys): void
    {
        foreach ($keys as $key) {
            if (!isset($array[$key])) {
                return;
            }
            $array = &$array[$key];
        }
        unset($array);
    }

    public static function arraySortByColumn(array &$array, string $column, int $direction = SORT_ASC, int $type = SORT_REGULAR): void
    {
        array_multisort(array_column($array, $column), $direction, $type, $array);
    }

    public static function arraySortByMultipleColumns(array &$array, array $columns, array $directions = [], array $types = []): void
    {
        $args = [];
        foreach ($columns as $index => $column) {
            $args[] = array_column($array, $column);
            $args[] = $directions[$index] ?? SORT_ASC;
            $args[] = $types[$index] ?? SORT_REGULAR;
        }
        $args[] = &$array;
        array_multisort(...$args);
    }

    public static function arraySortByObjectProperty(array &$array, string $property, int $direction = SORT_ASC, int $type = SORT_REGULAR): void
    {
        usort($array, fn($a, $b) => ($direction === SORT_ASC ? $a->$property <=> $b->$property : $b->$property <=> $a->$property));
    }

    public static function arraySortByMultipleObjectProperties(array &$array, array $properties, array $directions = [], array $types = []): void
    {
        usort($array, function ($a, $b) use ($properties, $directions, $types) {
            foreach ($properties as $index => $property) {
                $result = $directions[$index] === SORT_ASC ? $a->$property <=> $b->$property : $b->$property <=> $a->$property;
                if ($result !== 0) {
                    return $result;
                }
            }
            return 0;
        });
    }

    public static function objectToArray($object): array
    {
        return json_decode(json_encode($object), true);
    }

    public static function objectGetProperty($object, string $property, mixed $default = null): mixed
    {
        return $object->$property ?? $default;
    }

    public static function objectSetProperty($object, string $property, mixed $value): void
    {
        $object->$property = $value;
    }

    public static function objectUnsetProperty($object, string $property): void
    {
        unset($object->$property);
    }

    public static function objectToQueryString($object): string
    {
        return http_build_query($object);
    }

    public static function queryStringToObject(string $queryString)
    {
        parse_str($queryString, $params);
        return (object)$params;
    }

    // String methods...
    public static function stringContains(string $haystack, string $needle): bool
    {
        return str_contains($haystack, $needle);
    }

    public static function stringStartsWith(string $haystack, string $needle): bool
    {
        return str_starts_with($haystack, $needle);
    }

    public static function stringEndsWith(string $haystack, string $needle): bool
    {
        return str_ends_with($haystack, $needle);
    }

    public static function stringIsEmail(string $str): bool
    {
        return filter_var($str, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function stringIsUrl(string $str): bool
    {
        return filter_var($str, FILTER_VALIDATE_URL) !== false;
    }

    public static function stringIsIp(string $str): bool
    {
        return filter_var($str, FILTER_VALIDATE_IP) !== false;
    }

    public static function stringCamelToSnake(string $str): string
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1_', $str));
    }

    public static function stringSnakeToCamel(string $str, bool $capitaliseFirstChar = true): string
    {
        $str = str_replace('_', '', ucwords($str, '_'));
        return $capitaliseFirstChar ? ucfirst($str) : lcfirst($str);
    }

    public static function stringTruncate(string $str, int $length, string $ellipsis = '...'): string
    {
        return mb_strlen($str) > $length ? mb_substr($str, 0, $length - mb_strlen($ellipsis)) . $ellipsis : $str;
    }

    public static function stringRandom(int $length): string
    {
        return bin2hex(random_bytes($length / 2));
    }

    public static function stringBetween(string $str, string $start, string $end): string
    {
        preg_match('/(?<=' . preg_quote($start) . ')(.*)(?=' . preg_quote($end) . ')/s', $str, $matches);
        return $matches[0] ?? '';
    }

    public static function stringIsHexColor(string $str): bool
    {
        return preg_match('/^#[a-f0-9]{6}$/i', $str) === 1;
    }

    public static function stringToSlug(string $str): string
    {
        $str = preg_replace('/[^a-zA-Z0-9 -]/', '', $str);
        $str = strtolower(trim($str));
        $str = preg_replace('/[ ]+/', '-', $str);
        return $str;
    }

    public static function stringHumanFilesize(int $bytes, int $decimals = 2): string
    {
        $sz = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        $factor = (int)floor((strlen((string)$bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    public static function stringBase64UrlEncode(string $input): string
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    public static function stringBase64UrlDecode(string $input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public static function dateRange(string $startDate, string $endDate, string $format = 'Y-m-d'): array
    {
        $dates = [];
        $currentDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        while ($currentDate <= $endDate) {
            $dates[] = date($format, $currentDate);
            $currentDate = strtotime('+1 day', $currentDate);
        }
        return $dates;
    }

    public static function dateDiff(string $startDate, string $endDate): \DateInterval
    {
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);
        return $startDate->diff($endDate);
    }

    public static function dateIsValid(string $date, string $format = 'Y-m-d'): bool
    {
        $dateTime = DateTime::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) === $date;
    }

    public static function dateAddDays(string $date, int $days): string
    {
        $d = new DateTime($date);
        $d->modify('+' . $days . ' days');
        return $d->format('Y-m-d');
    }

    public static function dateSubtractDays(string $date, int $days): string
    {
        $d = new DateTime($date);
        $d->modify('-' . $days . ' days');
        return $d->format('Y-m-d');
    }

    public static function dateIsWeekend(string $date): bool
    {
        $day = date('N', strtotime($date));
        return ($day == 6 || $day == 7);
    }

    public static function dateIsToday(string $date): bool
    {
        return $date === date('Y-m-d');
    }

    public static function dateIsPast(string $date): bool
    {
        return strtotime($date) < time();
    }

    public static function dateIsFuture(string $date): bool
    {
        return strtotime($date) > time();
    }

    public static function fileIsImage(string $filename): bool
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        return in_array($ext, ['jpg', 'jpeg', 'gif', 'png', 'bmp']);
    }

    public static function fileGetContentsChunked(string $filePath, int $chunkSize, callable $callback): bool
    {
        $handle = fopen($filePath, 'rb');
        if ($handle === false) {
            return false;
        }
        while (!feof($handle)) {
            $chunk = fread($handle, $chunkSize);
            if ($chunk !== false) {
                if ($callback($chunk) === false) {
                    break;
                }
            } else {
                break;
            }
        }
        fclose($handle);
        return true;
    }

    public static function fileGetJson(string $filePath)
    {
        $json = file_get_contents($filePath);
        return json_decode($json, true);
    }

    public static function filePutJson(string $filePath, $data)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        return file_put_contents($filePath, $json);
    }

    public static function fileIsWritableRecursive(string $dirPath): bool
    {
        if (!is_dir($dirPath)) {
            return false;
        }
        if (!is_writable($dirPath)) {
            return false;
        }
        foreach (scandir($dirPath) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $path = $dirPath . '/' . $file;
            if (is_dir($path)) {
                if (!self::fileIsWritableRecursive($path)) {
                    return false;
                }
            } elseif (!is_writable($path)) {
                return false;
            }
        }
        return true;
    }

    public static function fileGetMimeType(string $filePath)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);
        return $mimeType;
    }

    public static function fileGetExtension(string $filePath)
    {
        return strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    }

    public static function fileCreateDirectory(string $dirPath): bool
    {
        return mkdir($dirPath, 0777, true);
    }

    public static function fileDeleteDirectory(string $dirPath): bool
    {
        if (!is_dir($dirPath)) {
            return false; // Return false if the path is not a directory.
        }
        foreach (scandir($dirPath) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $path = $dirPath . '/' . $file;
            if (is_dir($path)) {
                if (!self::fileDeleteDirectory($path)) {
                    return false;
                }
            } elseif (!unlink($path)) {
                return false;
            }
        }
        return rmdir($dirPath);
    }

    public static function fileCopyDirectory(string $sourceDirPath, string $destinationDirPath): void
    {
        if (!is_dir($destinationDirPath)) {
            mkdir($destinationDirPath, 0777, true);
        }
        foreach (scandir($sourceDirPath) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $sourcePath = $sourceDirPath . '/' . $file;
            $destinationPath = $destinationDirPath . '/' . $file;
            if (is_dir($sourcePath)) {
                self::fileCopyDirectory($sourcePath, $destinationPath);
            } else {
                copy($sourcePath, $destinationPath);
            }
        }
    }

    public static function fileMoveDirectory(string $sourceDirPath, string $destinationDirPath): bool
    {
        self::fileCopyDirectory($sourceDirPath, $destinationDirPath);
        return self::fileDeleteDirectory($sourceDirPath);
    }

    public static function fileZipDirectory(string $dirPath, string $zipFilePath): bool
    {
        if (!is_dir($dirPath)) {
            return false;
        }
        $zip = new ZipArchive();
        if (!$zip->open($zipFilePath, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE)) {
            return false;
        }
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dirPath));
        foreach ($iterator as $file) {
            if (!$file->isDir()) {
                $file_path = $file->getRealPath();
                $relative_path = substr($file_path, strlen($dirPath) + 1);
                $zip->addFile($file_path, $relative_path);
            }
        }
        $zip->close();
        return true;
    }

    public static function fileUnzip(string $zipFilePath, string $destinationDirPath): bool
    {
        $zip = new ZipArchive();
        if (!$zip->open($zipFilePath)) {
            return false;
        }
        $zip->extractTo($destinationDirPath);
        $zip->close();
        return true;
    }

    public static function fileDownload(string $filePath): void
    {
        if (!is_file($filePath)) {
            return;
        }
        $fileSize = filesize($filePath);
        $fileName = basename($filePath);
        $mimeType = self::fileGetMimeType($filePath);
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . $fileSize);
        readfile($filePath);
        exit();
    }

    public static function urlGetContents(string $url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public static function urlGetHttpStatus(string $url): int
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpStatus;
    }

    public static function arrayDeepMerge(array &$array1, array &$array2): array
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = self::arrayDeepMerge($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }

    public static function stringToTitleCase(string $str): string
    {
        return ucwords(strtolower($str));
    }

    public static function stringToSentenceCase(string $str): string
    {
        return ucfirst(strtolower($str));
    }

    public static function stringMask(string $str, int $start, int $end, string $mask = '*'): string
    {
        return substr($str, 0, $start) . str_repeat($mask, $end - $start) . substr($str, $end);
    }

    public static function dateIsLeapYear(int $year): bool
    {
        return (($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0);
    }

    public static function fileGetLines(string $filePath): int
    {
        $file = new SplFileObject($filePath, 'r');
        $file->seek(PHP_INT_MAX);
        return $file->key() + 1;
    }

    public static function urlGetDomain(string $url): string
    {
        $parsedUrl = parse_url($url);
        return $parsedUrl['host'] ?? '';
    }

    public static function stringIsJson(string $str): bool
    {
        json_decode($str);
        return json_last_error() === JSON_ERROR_NONE;
    }


    public static function stringIsBase64(string $str): bool
    {
        return base64_encode(base64_decode($str, true)) === $str;
    }


    public static function fileGetSize(string $filePath): int
    {
        return filesize($filePath);
    }


    public static function fileRename(string $oldPath, string $newPath): bool
    {
        return rename($oldPath, $newPath);
    }


    public static function fileDelete(string $filePath): bool
    {
        return unlink($filePath);
    }


    public static function fileGetHash(string $filePath, string $algorithm = 'md5'): string
    {
        return hash_file($algorithm, $filePath);
    }


    public static function urlEncode(string $str): string
    {
        return urlencode($str);
    }

    public static function urlDecode(string $str): string
    {
        return urldecode($str);
    }


    public static function mathRound(float $number, int $precision = 0, int $mode = PHP_ROUND_HALF_UP): float
    {
        return round($number, $precision, $mode);
    }

    public static function arrayFindDuplicates(array $array): array
    {
        return array_unique(array_diff_assoc($array, array_unique($array)));
    }

    public static function stringIsPalindrome(string $str): bool
    {
        $str = strtolower(preg_replace("/[^A-Za-z0-9]/", '', $str));
        return $str == strrev($str);
    }

    public static function dateIsWeekday(string $date): bool
    {
        $day = date('N', strtotime($date));
        return ($day >= 1 && $day <= 5);
    }

    public static function fileGetCreationTime(string $filePath): int
    {
        return filectime($filePath);
    }

    public static function urlGetPath(string $url): string
    {
        $parsedUrl = parse_url($url);
        return $parsedUrl['path'] ?? '';
    }
}
