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

use Graywings\PhpDockerTemplate\Comparator\SortOrder;
use ReturnTypeWillChange;

/**
 * Collection interface
 *
 * @category Graywings\PhpDockerTemplate\Collection
 * @package  Graywings\PhpDockerTemplate\Collection
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @template T
 * @extends  ArrayInterface<int, T>
 */
interface CollectionInterface extends ArrayInterface
{
    /**
     * Contains element within collection
     *
     * @param  T $element
     * @return bool
     */
    public function contains(mixed $element): bool;

    /**
     * Get column array
     *
     * @param  string $propertyOrMethod
     * @return array<int, mixed>
     */
    public function column(string $propertyOrMethod): array;

    /**
     * Get first element
     *
     * @return ?T
     */
    public function first(): mixed;

    /**
     * Get last element
     *
     * @return ?T
     */
    public function last(): mixed;

    /**
     * Filter callback
     *
     * @param  callable(T): bool $callback
     * @return CollectionInterface<T>
     */
    public function filter(callable $callback): self;

    /**
     * Filter value equals property
     *
     * @param  string|null $propertyOrMethod
     * @param  mixed       $value
     * @return CollectionInterface<T>
     */
    public function where(?string $propertyOrMethod, mixed $value): self;

    /**
     * Collection Map
     *
     * @template TCallbackReturn
     * @param    callable(T): TCallbackReturn $callback
     * @return   CollectionInterface<TCallbackReturn>
     */
    public function map(callable $callback): self;

    /**
     * Collection Reduce
     *
     * @template TCarry
     * @param    callable(TCarry, T): TCarry $callback
     * @param    TCarry                      $initial
     * @return   TCarry
     */
    public function reduce(callable $callback, mixed $initial): mixed;

    /**
     * Diff collection
     *
     * @param  CollectionInterface<T> $other
     * @return CollectionInterface<T>
     */
    public function diff(self $other): self;

    /**
     * Intersect collection
     *
     * @param  CollectionInterface<T> $other
     * @return CollectionInterface<T>
     */
    public function intersect(self $other): self;

    /**
     * Add to collection
     *
     * @param  T $element
     * @return bool
     */
    public function add(mixed $element): bool;

    /**
     * Get collection type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Remove element
     *
     * @param  T $element
     * @return bool
     */
    public function remove(mixed $element): bool;

    /**
     * Sort collection
     *
     * @param  string|null $propertyOrMethod
     * @param  SortOrder $order
     * @return void
     */
    public function sort(
        ?string $propertyOrMethod = null,
        SortOrder $order = SortOrder::ASC
    ): void;

    /**
     * Merge collection
     *
     * @param  CollectionInterface<T> ...$collections
     * @return CollectionInterface<T>
     */
    public function merge(self ...$collections): self;
}
