<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Str
 * @package  Graywings\PhpDockerTemplate\Str
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Str;

/**
 * Str utility
 *
 * @category Graywings\PhpDockerTemplate\Str
 * @package  Graywings\PhpDockerTemplate\Str
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
class Str
{
    /**
     * Change string case
     *
     * @param  string $target
     * @param  CaseType $before
     * @param  CaseType $after
     * @return string
     */
    public static function changeCase(
        string   $target,
        CaseType $before,
        CaseType $after
    ): string {
        return match ($before) {
            CaseType::LOWER_CAMEL => match ($after) {
                CaseType::LOWER_CAMEL => $target,
                CaseType::UPPER_CAMEL => ucfirst($target),
                CaseType::SCREAMING_SNAKE => self::lowerCamelToScreamSnakeTo($target),
                CaseType::SNAKE => self::lowerCamelToSnake($target),
                CaseType::KEBAB => self::lowerCamelToKebab($target),
            },
            CaseType::UPPER_CAMEL => match ($after) {
                CaseType::LOWER_CAMEL => lcfirst($target),
                CaseType::UPPER_CAMEL => $target,
                CaseType::SCREAMING_SNAKE => self::upperCamelToScreamingSnake($target),
                CaseType::SNAKE => self::upperCamelToSnake($target),
                CaseType::KEBAB => self::upperCamelToKebab($target),
            },
            CaseType::SCREAMING_SNAKE => match ($after) {
                CaseType::LOWER_CAMEL => self::screamingSnakeToLowerCamel($target),
                CaseType::UPPER_CAMEL => self::screamingSnakeToUpperCamel($target),
                CaseType::SCREAMING_SNAKE => $target,
                CaseType::SNAKE => strtolower($target),
                CaseType::KEBAB => self::screamingSnakeToKebab($target)
            },
            CaseType::SNAKE => match ($after) {
                CaseType::LOWER_CAMEL => self::snakeToLowerCamel($target),
                CaseType::UPPER_CAMEL => self::snakeToUpperCamel($target),
                CaseType::SCREAMING_SNAKE => $target,
                CaseType::SNAKE => strtolower($target),
                CaseType::KEBAB => str_replace('_', '-', $target)
            },
            CaseType::KEBAB => match ($after) {
                CaseType::LOWER_CAMEL => self::kebabToLowerCamel($target),
                CaseType::UPPER_CAMEL => self::kebabToUpperCamel($target),
                CaseType::SCREAMING_SNAKE => self::kebabToScreamingSnake($target),
                CaseType::SNAKE => str_replace('-', '_', $target),
                CaseType::KEBAB => $target
            },
        };
    }

    public static function lowerCamelToScreamSnakeTo(
        string $target
    ): string {
        $replaced = preg_replace(
            '/[A-Z]([A-Z](?![a-z]))*/',
            '_$0',
            $target
        );
        if ($replaced === null) {
            return '';
        }
        return ltrim(
            strtoupper($replaced),
            '_'
        );
    }

    public static function lowerCamelToSnake(
        string $target
    ): string {
        $replaced = preg_replace(
            '/[A-Z]([A-Z](?![a-z]))*/',
            '_$0',
            $target
        );
        if ($replaced === null) {
            return '';
        }
        return ltrim(
            strtolower($replaced),
            '_'
        );
    }

    public static function lowerCamelToKebab(
        string $target
    ): string {
        $replaced = preg_replace(
            '/[A-Z]([A-Z](?![a-z]))*/',
            '-$0',
            $target
        );
        if ($replaced === null) {
            return '';
        }
        return ltrim(
            strtolower($replaced),
            '-'
        );
    }

    public static function upperCamelToScreamingSnake(
        string $target
    ): string {
        $replaced = preg_replace(
            '/[A-Z]([A-Z](?![a-z]))*/',
            '_$0',
            $target
        );
        if ($replaced === null) {
            return '';
        }
        return ltrim(
            strtoupper($replaced),
            '_'
        );
    }

    public static function upperCamelToSnake(
        string $target
    ): string {
        $replaced = preg_replace(
            '/[A-Z]([A-Z](?![a-z]))*/',
            '_$0',
            $target
        );
        if ($replaced === null) {
            return '';
        }
        return ltrim(
            strtolower($replaced),
            '_'
        );
    }

    public static function upperCamelToKebab(
        string $target
    ): string {
        $replaced = preg_replace(
            '/[A-Z]([A-Z](?![a-z]))*/',
            '-$0',
            $target
        );
        if ($replaced === null) {
            return '';
        }
        return ltrim(
            strtolower($replaced),
            '-'
        );
    }

    public static function screamingSnakeToLowerCamel(
        string $target
    ): string {
        return lcfirst(
            str_replace(
                ' ',
                '',
                ucwords(
                    strtolower(
                        str_replace(
                            '_',
                            ' ',
                            $target
                        )
                    )
                )
            )
        );
    }

    public static function screamingSnakeToUpperCamel(
        string $target
    ): string {
        return str_replace(
            ' ',
            '',
            ucwords(
                strtolower(
                    str_replace(
                        '_',
                        ' ',
                        $target
                    )
                )
            )
        );
    }

    public static function screamingSnakeToKebab(
        string $target
    ): string {
        return strtolower(
            str_replace(
                '_',
                '-',
                $target
            )
        );
    }

    public static function snakeToLowerCamel(
        string $target
    ): string {
        return lcfirst(
            str_replace(
                ' ',
                '',
                ucwords(
                    str_replace(
                        '_',
                        ' ',
                        $target
                    )
                )
            )
        );
    }

    public static function snakeToUpperCamel(
        string $target
    ): string {
        return str_replace(
            ' ',
            '',
            ucwords(
                str_replace(
                    '_',
                    ' ',
                    $target
                )
            )
        );
    }

    public static function kebabToLowerCamel(
        string $target
    ): string {
        return lcfirst(
            str_replace(
                ' ',
                '',
                ucwords(
                    str_replace(
                        '-',
                        ' ',
                        $target
                    )
                )
            )
        );
    }

    public static function kebabToUpperCamel(
        string $target
    ): string {
        return str_replace(
            ' ',
            '',
            ucwords(
                str_replace(
                    '-',
                    ' ',
                    $target
                )
            )
        );
    }

    public static function kebabToScreamingSnake(
        string $target
    ): string {
        return strtoupper(
            str_replace(
                '-',
                '_',
                $target
            )
        );
    }
}
