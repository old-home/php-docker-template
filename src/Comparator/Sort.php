<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Comparator
 * @package  Graywings\PhpDockerTemplate\Comparator
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Comparator;

use Graywings\PhpDockerTemplate\Collection\Collection;
use Graywings\PhpDockerTemplate\Exception\NotImplementedException;

/**
 * Sort
 *
 * @category Graywings\PhpDockerTemplate\Comparator
 * @package  Graywings\PhpDockerTemplate\Comparator
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 * @template T
 */
class Sort
{
    /**
     * Bubble sort
     *
     * @return Collection<T>
     */
    public static function bubble(): Collection
    {
        throw new NotImplementedException();
    }

    /**
     * Quick sort
     *
     * @return Collection<T>
     */
    public static function quick(): Collection
    {
        throw new NotImplementedException();
    }

    /**
     * Merge sort
     *
     * @return Collection<T>
     */
    public static function merge(): Collection
    {
        throw new NotImplementedException();
    }

    /**
     * Select sort
     *
     * @return Collection<T>
     */
    public static function select(): Collection
    {
        throw new NotImplementedException();
    }

    /**
     * Insert sort
     *
     * @return Collection<T>
     */
    public static function insert(): Collection
    {
        throw new NotImplementedException();
    }

    /**
     * Heap sort
     *
     * @return Collection<T>
     */
    public static function heap(): Collection
    {
        throw new NotImplementedException();
    }
}
