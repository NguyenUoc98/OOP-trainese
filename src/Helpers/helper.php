<?php
/**
 * Created by PhpStorm.
 * Filename: helper.php
 * User: Nguyễn Văn Ước
 * Date: 28/09/2022
 * Time: 14:04
 */

if (!function_exists('config')) {
    function config(string $path)
    {
        $configs = require __DIR__ . '/../configs/config.php';
        $params  = explode('.', $path);

        foreach ($params as $param) {
            if (isset($configs[$param])) {
                $configs = $configs[$param];
            } else {
                return null;
            }
        }
        return $configs;
    }
}
