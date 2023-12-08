<?php
/** @noinspection PhpDocSignatureInspection */

declare(strict_types=1);

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Temp
 * @package  Graywings\PhpDockerTemplate\Temp
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Comparator;

use InvalidArgumentException;

/**
 * Interface comparable
 *
 * @category Graywings\PhpDockerTemplate\Comparator
 * @package  Graywings\PhpDockerTemplate\Comparator
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @template-covariant T of IComparable
 */
interface IComparable
{
    /**
     * Compares this object with the specified object for order.
     * Returns a negative integer, zero, or a positive integer
     * as this object is less than, equal to, or greater than the specified object.
     *
     * @param T $other The object to be compared.
     * @return int A negative integer if this object is less than the specified object,
     *             zero if they are equal, or a positive integer if this object is greater than the specified object.
     * @throws InvalidArgumentException If other object is not Template type.
     */
    public function compare(IComparable $other): int;
}
