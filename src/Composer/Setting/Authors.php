<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Composer\Setting;

use Graywings\PhpDockerTemplate\Collection\Collection;
use Graywings\PhpDockerTemplate\Collection\CollectionType;

/**
 * Author Collection
 *
 * @category Graywings\PhpDockerTemplate\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 * @extends  Collection<Author>
 */

#[CollectionType(Author::class)]
class Authors extends Collection
{
}
