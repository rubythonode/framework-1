<?php

use Illuminate\Support\Facades\Request;
use Litepie\Support\Facades\Hashids;
use Litepie\Support\Facades\Trans;

if (!function_exists('hashids_encode')) {
    /**
     * Encode the given id.
     *
     * @param int/array $id
     *
     * @return string
     */
    function hashids_encode($idorarray)
    {
        return Hashids::encode($idorarray);
    }

}

if (!function_exists('hashids_decode')) {
    /**
     * Decode the given value.
     *
     * @param string $value
     *
     * @return array / int
     */
    function hashids_decode($value)
    {
        $return = Hashids::decode($value);

        if (empty($return)) {
            return null;
        }

        if (count($return) == 1) {
            return $return[0];
        }

        return $return;
    }

}

if (!function_exists('folder_new')) {
    /**
     * Get new upload folder pathes.
     *
     * @param string $prefix
     * @param string $sufix
     *
     * @return array
     */
    function folder_new($prefix = null, $sufix = null)
    {
        $arr = [];

        $prefix        = empty($prefix) ? null : $prefix . '/';
        $sufix         = empty($sufix) ? null : '/' . $sufix;
        $folder        = date('Y/m/d/His') . rand(100, 999);
        $arr['folder'] = $prefix . $folder . $sufix;

        $folder           = folderEncode($folder);
        $arr['encrypted'] = $prefix . $folder . $sufix;

        return $arr;
    }

}

if (!function_exists('folder_encode')) {
    /**
     * Encrypt upload folder.
     *
     * @param string $folder
     *
     * @return string
     */
    function folder_encode($folder)
    {
        $arr = explode('/', $folder);

        return hashidsEncode($arr);
    }

}

if (!function_exists('folder_decode')) {
    /**
     * Get decoded folder.
     *
     * @param array $folder
     *
     * @return string
     */
    function folder_decode($folder)
    {
        $formatFolder = function ($folder) {
            return str_pad($folder[0], 4, '0', STR_PAD_LEFT) . '/'
            . str_pad($folder[1], 2, '0', STR_PAD_LEFT) . '/'
            . str_pad($folder[2], 2, '0', STR_PAD_LEFT) . '/'
            . str_pad($folder[3], 9, '0', STR_PAD_LEFT);
        };

        $arr = explode('/', $folder);

        if (count($arr) == 1) {
            $folder = hashidsDecode($arr[0]);

            return $formatFolder($folder);
        }

        if (count($arr) == 2) {
            $folder = hashidsDecode($arr[1]);

            return $arr[0] . '/' . $formatFolder($folder);
        }

        $folder = hashidsDecode($arr[1]);

        return $arr[0] . '/' . $formatFolder($folder) . '/' . $arr[2];
    }

}

if (!function_exists('trans_url')) {
    /**
     * Get translated url.
     *
     * @param string $url
     *
     * @return string
     */
    function trans_url($url)
    {
        return Trans::to($url);
    }

}

if (!function_exists('trans_setlocale')) {
    /**
     * Set local for the translation
     *
     * @param string $locale
     *
     * @return string
     */
    function trans_setlocale($locale = null)
    {
        return Trans::setLocale($locale);
    }

}

if (!function_exists('checkbox_array')) {
    /**
     * Convert array to use in form check box
     *
     * @param array $array
     * @param string $name
     * @param array $options
     *
     * @return array
     */
    function checkbox_array(array $array, $name, $options = [])
    {
        $return = [];

        foreach ($array as $key => $val) {
            $return[$val] = array_merge(['name' => "{$name}[{$key}]"], $options);
        }

        return $return;
    }

}

if (!function_exists('pager_array')) {
    /**
     * Return request values to be used in paginator
     *
     * @return array
     */
    function pager_array()
    {

        return Request::only(
            config('database.criteria.params.search', 'search'),
            config('database.criteria.params.searchFields', 'searchFields'),
            config('database.criteria.params.columns', 'columns'),
            config('database.criteria.params.sortBy', 'sortBy'),
            config('database.criteria.params.orderBy', 'orderBy'),
            config('database.criteria.params.with', 'with')
        );
    }

}

if (!function_exists('user_id')) {
    /**
     * Get user id.
     *
     * @param string $guard
     *
     * @return int
     */
    function user_id($guard = null)
    {

        if (Auth::guard($guard)->check()) {
            return Auth::guard($guard)->user()->id;
        }

    }

}

if (!function_exists('users')) {
    /**
     * Get upload folder.
     *
     * @param string $folder
     *
     * @return string
     */
    function users($property, $guard = null)
    {

        if (Auth::guard($guard)->check()) {
            return Auth::guard($guard)->user()->$property;
        }

    }

}

if (!function_exists('user')) {
    /**
     * Return the user model
     * @param type|null $guard
     * @return type
     */
    function user($guard = null)
    {

        if (Auth::guard($guard)->check()) {
            return Auth::guard($guard)->user();
        }

        return null;
    }

}

if (!function_exists('format_date')) {
    /**
     * Format date
     *
     * @param string $date
     * @param string $format
     *
     * @return date
     */
    function format_date($date, $format = 'd M, Y')
    {
        return date($format, strtotime($date));
    }

}

if (!function_exists('format_date_time')) {
    /**
     * Format datetime
     *
     * @param date $datetime
     * @param string $format
     *
     * @return datetime
     */
    function format_date_time($datetime, $format = 'd M, Y h:i A')
    {
        return date($format, strtotime($datetime));
    }

}

if (!function_exists('format_time')) {
    /**
     * Format time.
     *
     * @param string $time
     * @param string $format
     *
     * @return time
     */
    function format_time($time, $format = 'h:i A')
    {
        return date($format, strtotime($time));
    }

}
