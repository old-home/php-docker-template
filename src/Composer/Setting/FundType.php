<?php

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

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Composer\Setting;

/**
 * Fund type
 *
 * @category Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
enum FundType: string
{
    case PATREON = 'patreon';
    case OPEN_COLLECTIVE = 'opencollective';
    case TIDELIFT = 'tidelift';
    case GITHUB = 'github';
    case OTHER = 'other';
}
