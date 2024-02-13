<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category     Graywings\PhpDockerTemplate\Comparator
 * @package      Graywings\PhpDockerTemplate\Comparator
 * @author       Taira Terashima <taira.terashima@gmail.com>
 * @license      MIT https://opensource.org/licenses/MIT
 * @link         https://github.com/old-home/php-docker-template
 * @noinspection PhpDocSignatureInspection
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Comparator;

/**
 * Compare IComparable
 *
 * @category Graywings\PhpDockerTemplate\Comparator
 * @package  Graywings\PhpDockerTemplate\Comparator
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
final class Comparator
{
    /**
     * Comparator constructor
     *
     * @template T of IComparable
     * @param    T $self
     * @param    T $other
     *
     * @return boolean
     */
    public static function equals(
        IComparable $self,
        IComparable $other
    ): bool {
        return $self->compare($other) === 0;
    }

    /**
     * Is less than
     *
     * @template T of IComparable
     * @param    T $self
     * @param    T $other
     *
     * @return boolean
     */
    public static function lessThan(
        IComparable $self,
        IComparable $other
    ): bool {
        return $self->compare($other) < 0;
    }

    /**
     * Is less than equal
     *
     * @template T of IComparable
     * @param    T $self
     * @param    T $other
     *
     * @return boolean
     */
    public static function lessThanEqual(
        IComparable $self,
        IComparable $other
    ): bool {
        return $self->compare($other) <= 0;
    }

    /**
     * Is greater than
     *
     * @template T of IComparable
     * @param    T $self
     * @param    T $other
     *
     * @return boolean
     */
    public static function greaterThan(
        IComparable $self,
        IComparable $other
    ): bool {
        return $self->compare($other) > 0;
    }

    /**
     * Is greater than equal
     *
     * @template T of IComparable
     * @param    T $self
     * @param    T $other
     *
     * @return boolean
     */
    public static function greaterThanEqual(
        IComparable $self,
        IComparable $other
    ): bool {
        return $self->compare($other) >= 0;
    }
}
