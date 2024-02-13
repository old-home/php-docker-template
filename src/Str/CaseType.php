<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Serializer
 * @package  Graywings\PhpDockerTemplate\Serializer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Str;

/**
 * Naming rule types
 *
 * @category Graywings\PhpDockerTemplate\Serializer
 * @package  Graywings\PhpDockerTemplate\Serializer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
enum CaseType
{
    case LOWER_CAMEL;
    case UPPER_CAMEL;
    case SNAKE;
    case SCREAMING_SNAKE;
    case KEBAB;
}
