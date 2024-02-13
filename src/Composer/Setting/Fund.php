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

use Graywings\Etter\Etter;
use Graywings\Etter\Get;

/**
 * Fund information
 *
 * @category Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read FundType $type
 * @property-read string $url
 */
readonly class Fund
{
    use Etter;

    public function __construct(
        #[Get] private FundType $type,
        #[Get] private string $url
    ) {
    }
}
