<?php

declare(strict_types=1);

/**
 * Copyright ©2023 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Composer\Setting;

use Graywings\Etter\Etter;
use Graywings\Etter\Get;

/**
 * Author
 *
 * @category Graywings\PhpDockerTemplate\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read string $userName
 * @property-read string $email
 * @property-read string $homepage
 * @property-read string $role
 */
readonly class Author
{
    use Etter;
    public function __construct(
        #[Get] private string $userName,
        #[Get] private string $email,
        #[Get] private string $homepage = '',
        #[Get] private string $role = ''
    )
    {
    }
}
