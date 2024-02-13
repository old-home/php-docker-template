<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Collection
 * @package  Graywings\PhpDockerTemplate\Collection
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Collection;

use Attribute;
use Graywings\Etter\Etter;
use Graywings\Etter\Get;

/**
 * Collection type
 *
 * @category Graywings\PhpDockerTemplate\Collection
 * @package  Graywings\PhpDockerTemplate\Collection
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read string $typeName
 */
#[Attribute(Attribute::TARGET_CLASS)]
readonly class CollectionType
{
    use Etter;

    public function __construct(
        #[Get] private string $typeName
    ) {
    }
}
