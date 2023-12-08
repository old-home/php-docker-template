<?php

declare(strict_types=1);

/**
 * Copyright ©2023 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Temp
 * @package  Graywings\PhpDockerTemplate\Temp
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Composer\Setting;

/**
 * Composer package type
 *
 * @category Graywings\PhpDockerTemplate\Temp
 * @package  Graywings\PhpDockerTemplate\Temp
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
enum PackageType: string
{
    case LIBRARY = 'library';
    case PROJECT = 'project';
    case METAPACKAGE = 'metapackage';
    case COMPOSER_PLUGIN = 'composer-plugin';
}
