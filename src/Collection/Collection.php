<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate
 * @package  Graywings\PhpDockerTemplate
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Collection;

use ArrayIterator;
use Graywings\Etter\Etter;
use Graywings\Etter\Get;
use Graywings\PhpDockerTemplate\Comparator\SortOrder;
use Override;
use ReflectionClass;
use Throwable;
use Traversable;

use function array_column;
use function array_diff;
use function array_filter;
use function array_intersect;
use function array_map;
use function array_merge;
use function array_reduce;
use function array_search;
use function count;
use function end;
use function in_array;
use function reset;

/**
 * Collection
 *
 * @category Graywings\PhpDockerTemplate
 * @package  Graywings\PhpDockerTemplate
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @template   T
 * @implements CollectionInterface<T>
 *
 * @property-read string $typeName
 * @property-read array $elements
 */
abstract class Collection implements CollectionInterface
{
    use Etter;

    #[Get]
    private string $typeName;

    /**
     * Collection constructor
     *
     * @param array<int, T> $elements
     */
    final public function __construct(
        #[Get] private array           $elements = []
    ) {
        try {
            $reflectionClass = new ReflectionClass($this);
            $reflectionAttributes = $reflectionClass->getAttributes(CollectionType::class);
            /**
             * Collection type attribute
             *
             * @var CollectionType $collectionType
             */
            $collectionType = $reflectionAttributes[0]->newInstance();
            $this->typeName = $collectionType->typeName;
        } catch (Throwable) {
            $this->typeName = 'mixed';
        }
    }

    /**
     * Offset exists
     *
     * @param  integer $offset
     * @return boolean
     */
    #[Override]
    public function offsetExists(
        mixed $offset
    ): bool {
        return isset($this->elements[$offset]);
    }

    /**
     * Get value from offset
     *
     * @param  integer $offset
     * @return T
     */
    #[Override]
    public function offsetGet(
        mixed $offset
    ): mixed {
        return $this->elements[$offset];
    }

    /**
     * Set Value to offset
     *
     * @param  integer $offset
     * @param  T $value
     * @return void
     */
    #[Override]
    public function offsetSet(
        mixed $offset,
        mixed $value
    ): void {
        $this->elements[$offset] = $value;
    }

    /**
     * Unset offset value
     *
     * @param  integer $offset
     * @return void
     */
    #[Override]
    public function offsetUnset(
        mixed $offset
    ): void {
        unset($this->elements[$offset]);
    }

    /**
     * Count collection
     *
     * @return integer
     */
    #[Override]
    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * Get collection's iterator
     *
     * @return Traversable<int, T>
     */
    #[Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

    #[Override]
    public function clear(): void
    {
        $this->elements = [];
    }

    #[Override]
    public function toArray(): array
    {
        return $this->elements;
    }

    #[Override]
    public function isEmpty(): bool
    {
        return empty($this->elements);
    }

    #[Override]
    public function add(mixed $element): bool
    {
        return array_push($this->elements, $element) > 0;
    }

    #[Override]
    public function contains(mixed $element): bool
    {
        return in_array($element, $this->elements);
    }

    #[Override]
    public function getType(): string
    {
        return $this->typeName;
    }

    #[Override]
    public function remove(
        mixed $element
    ): bool {
        $searched = array_search(
            $element,
            $this->elements,
            true
        );
        if ($searched === false) {
            return false;
        }
        unset($this->elements[$searched]);
        return true;
    }

    #[Override]
    public function column(
        string $propertyOrMethod
    ): array {
        return array_column($this->elements, $propertyOrMethod);
    }

    #[Override]
    public function first(): mixed
    {
        $firstElement = reset($this->elements);
        if ($firstElement === false) {
            return null;
        } else {
            return $firstElement;
        }
    }

    #[Override]
    public function last(): mixed
    {
        $lastElement = end($this->elements);
        reset($this->elements);
        if ($lastElement === false) {
            return null;
        } else {
            return $lastElement;
        }
    }

    #[Override]
    public function sort(
        ?string   $propertyOrMethod = null,
        SortOrder $order = SortOrder::ASC
    ): void {
    }

    /**
     * Filter collection
     *
     * @param  callable $callback
     * @return Collection<T>
     */
    #[Override]
    public function filter(
        callable $callback
    ): Collection {
        return new static(
            array_filter(
                $this->elements,
                $callback
            )
        );
    }

    #[Override]
    public function where(
        ?string $propertyOrMethod,
        mixed   $value
    ): CollectionInterface {
        $filtered = [];
        foreach ($this->elements as $element) {
            if ($propertyOrMethod === null) {
                if ($value === $element) {
                    $filtered[] = $element;
                }
            } else {
                if (is_callable($element->$propertyOrMethod)) {
                    if ($element->$propertyOrMethod() === $value) {
                        $filtered[] = $element;
                    }
                } else {
                    if ($element->$propertyOrMethod === $value) {
                        $filtered[] = $element;
                    }
                }
            }
        }
        return new static(
            $filtered
        );
    }

    /**
     * Collection Map
     *
     * @template TCallbackReturn
     * @param    callable(T): TCallbackReturn $callback
     * @return   CollectionInterface<TCallbackReturn>
     */
    #[Override]
    public function map(
        callable $callback
    ): CollectionInterface {
        /**
         * Return
         *
         * @var CollectionInterface<TCallbackReturn>
         */
        return new static(
            array_map(
                $callback,
                $this->elements
            )
        );
    }

    /**
     * Reduce collection by callback
     *
     * @inheritDoc
     */
    #[Override]
    public function reduce(
        callable $callback,
        mixed    $initial
    ): mixed {
        return array_reduce($this->elements, $callback, $initial);
    }

    /**
     * Diff collection
     *
     * @param  Collection<T> $other
     * @return CollectionInterface<T>
     */
    #[Override]
    public function diff(
        CollectionInterface $other
    ): CollectionInterface {
        return new static(
            array_diff(
                $this->elements,
                $other->elements
            )
        );
    }

    /**
     * Intersect collection
     *
     * @param  Collection<T> $other
     * @return CollectionInterface<T>
     */
    #[Override]
    public function intersect(
        CollectionInterface $other
    ): CollectionInterface {
        return new static(
            array_intersect(
                $this->elements,
                $other->elements
            )
        );
    }

    /**
     * Merge collection
     *
     * @param  Collection<T> ...$collections
     * @return CollectionInterface<T>
     */
    #[Override]
    public function merge(
        CollectionInterface ...$collections
    ): CollectionInterface {
        $merged = $this->elements;
        /**
         * Collection
         *
         * @var Collection<T> $collection
         */
        foreach ($collections as $collection) {
            $merged = array_merge($merged, $collection->elements);
        }
        /**
         * Return
         *
         * @var CollectionInterface<T>
         */
        return new static(
            array_merge(
                $this->elements,
                $merged
            )
        );
    }
}
