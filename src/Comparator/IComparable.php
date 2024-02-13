<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category     Graywings\PhpDockerTemplate\Temp
 * @package      Graywings\PhpDockerTemplate\Temp
 * @author       Taira Terashima <taira.terashima@gmail.com>
 * @license      MIT https://opensource.org/licenses/MIT
 * @link         https://github.com/old-home/php-docker-template
 * @noinspection PhpDocSignatureInspection
 */

declare(strict_types=1);

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
 * @template T of IComparable
 */
interface IComparable
{
    /**
     * Compare an object and another.
     *
     * @param  T $other The object to be compared.
     * @return int A negative integer if this object is less than the specified object,
     *             zero if they are equal, or a positive integer if this object is greater than the specified object.
     * @throws InvalidArgumentException If other object is not Template type.
     */
    public function compare(IComparable $other): int;
}
