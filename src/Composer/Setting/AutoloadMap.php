<?php

declare(strict_types=1);

/**
 * Copyright ©2023 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Composer\Setting;

use Graywings\Etter\Etter;
use Graywings\Etter\Get;

/**
 * Composer autoload mapping
 *
 * @category Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read PackageName $packageName
 * @property-read string $path
 */
readonly class AutoloadMap
{
    use Etter;
    public function __construct(
        #[Get] private PackageName $packageName,
        #[Get] private string $path
    )
    {
    }
}
