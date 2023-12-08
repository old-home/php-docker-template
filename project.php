<?php

declare(strict_types=1);

/**
 * Copyright ©2023 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

if (!function_exists('toUpperCamel')) {
    function toUpperCamel(string $value): string
    {
        $array = explode('-', $value);
        $ucArray = array_map(function (string $word): string {
            return ucwords($word);
        }, $array);
        return implode('', $ucArray);
    }
}

if (!defined('COMPOSER_JSON' = 'composer.json')) {
    define('COMPOSER_JSON', 'composer.json');
}

echo 'Enter package name(user_name/project_name): ' . "\n";

$packageName = fgets(STDIN);

if ($packageName) {
    $packageName = trim($packageName);
    $parsedPackage = explode('/', $packageName);
    if (count($parsedPackage) !== 2) {
        echo "Failed.\n";
        require __FILE__;
        exit;
    }
} else {
    echo "Failed.\n";
    require __FILE__;
    exit;
}

$upperCamelUserName = toUpperCamel($parsedPackage[0]);
$upperCamelProjectName = toUpperCamel($parsedPackage[1]);
$namespaceName = $upperCamelUserName . '\\\\' . $upperCamelProjectName;

echo "Settings...\n";
echo 'Package name: ' . $packageName . "\n";
echo 'namespace: ' . $namespaceName . "\n";

$srcFiles = scandir('src/');
$testFiles = scandir('tests/');

$files = [
    COMPOSER_JSON
];

foreach ($files as $file) {
    $contents = file($file);
    if (!$contents) {
        echo "Failed read composer.json\n";
        echo "Check composer.json and its permission and execute command:\n";
        echo "\n";
        echo "make project\n";
        exit;
    }

    $fp = fopen($file, 'w');
    if (!$fp) {
        echo "Failed opening composer.json\n";
        echo "Check composer.json and its permission and execute command:\n";
        echo "\n";
        echo "make project\n";
        exit;
    }
    /**
     * @var array<string, string> $replaceArray
     */
    $replaceArray = [
        'graywings/php-docker-template' => $packageName,
        'Graywings\\\\PhpDockerTemplate' => $namespaceName
    ];

    $newCompsoerJson = '';
    foreach ($contents as $line) {
        foreach ($replaceArray as $target => $replace) {
            $line = str_replace($target, $replace, $line);
        }
        $newCompsoerJson .= $line;
    }

    fwrite($fp, $newCompsoerJson, strlen($newCompsoerJson));
    fclose($fp);
}

system('composer dump-autoload');

unlink(__FILE__);
