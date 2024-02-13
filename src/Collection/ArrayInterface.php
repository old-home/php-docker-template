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

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * Collection interface
 *
 * @category Graywings\PhpDockerTemplate\Collection
 * @package  Graywings\PhpDockerTemplate\Collection
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @template K of array-key
 * @template T
 * @extends  ArrayAccess<K, T>
 * @extends  IteratorAggregate<K, T>
 */
interface ArrayInterface extends
    ArrayAccess,
    Countable,
    IteratorAggregate
{
    /**
     * Clear array data
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Object to array
     *
     * @return array<K, T>
     */
    public function toArray(): array;

    /**
     * Is empty
     *
     * @return boolean
     */
    public function isEmpty(): bool;
}
