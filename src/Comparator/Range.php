<?php
/** @noinspection PhpDocSignatureInspection */
/** @noinspection PhpDocFieldTypeMismatchInspection */

declare(strict_types=1);

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

namespace Graywings\PhpDockerTemplate\Comparator;

use Graywings\Etter\Etter;
use Graywings\Etter\Get;

/**
 * Range trait
 *
 * @category Graywings\PhpDockerTemplate\Comparator
 * @package  Graywings\PhpDockerTemplate\Comparator
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @template T of IComparable
 */
trait Range
{
    use Etter;

    /**
     * @var T|null $sup
     */
    #[Get]
    protected readonly IComparable|null $sup;

    /**
     * @var bool $supIsMax
     */
    #[Get]
    protected readonly bool $supIsMax;

    /**
     * @var T|null $inf
     */
    #[Get]
    protected readonly IComparable|null $inf;

    /**
     * @var bool $infIsMin
     */
    #[Get]
    protected readonly bool $infIsMin;

    /**
     * @param T $value
     *
     * @return bool
     */
    public function contains(IComparable $value): bool
    {
        if ($this->sup !== null) {
            if ($this->supIsMax) {
                $supCondition = Comparator::lessThanEqual(
                    $value,
                    $this->sup
                );
            } else {
                $supCondition = Comparator::lessThan(
                    $value,
                    $this->sup
                );
            }
        } else {
            $supCondition = true;
        }

        if ($this->inf !== null) {
            if ($this->infIsMin) {
                $infCondition = Comparator::greaterThanEqual(
                    $value,
                    $this->inf
                );
            } else {
                $infCondition = Comparator::greaterThan(
                    $value,
                    $this->inf
                );
            }
        } else {
            $infCondition = true;
        }

        return $supCondition && $infCondition;
    }
}
