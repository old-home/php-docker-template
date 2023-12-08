<?php

declare(strict_types=1);

/**
 * Copyright ©2023 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Temp\Composer
 * @package  Graywings\PhpDockerTemplate\Temp\Composer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Version\SemVer;

use DomainException;
use Graywings\PhpDockerTemplate\Comparator\IComparable;
use InvalidArgumentException;
use Override;

/**
 * Stability type
 *
 * @category Graywings\PhpDockerTemplate\Temp\Composer
 * @package  Graywings\PhpDockerTemplate\Temp\Composer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
enum StabilityType: string
    implements IComparable
{
    case DEV = 'dev';
    case ALPHA = 'alpha';
    case BETA = 'beta';
    case RELEASE_CANDIDATE = 'RC';
    case STABLE = 'stable';
    case PATCH = 'patch';

    /**
     * Parses a stability type and returns the corresponding object representation.
     *
     * @param string $stabilityType The stability type to parse.
     *
     * @return self The object representation of the parsed stability type.
     * @throws DomainException If the stability type is not supported.
     */
    public static function parse(string $stabilityType): self
    {
        return match ($stabilityType) {
            'dev' => self::DEV,
            'alpha', 'a' => self::ALPHA,
            'beta', 'b' => self::BETA,
            'RC' => self::RELEASE_CANDIDATE,
            '', 'stable' => self::STABLE,
            'patch', 'pl', 'p' => self::PATCH,
            default => throw new DomainException('Stability ' . $stabilityType . ' is not supported.')
        };
    }

    /**
     * Determines the order of the current stability.
     *
     * @return int The order of the current stability.
     */
    private function order(): int
    {
        return match ($this) {
            self::DEV => 1,
            self::ALPHA => 2,
            self::BETA => 3,
            self::RELEASE_CANDIDATE => 4,
            self::STABLE => 5,
            self::PATCH => 6
        };
    }

    /**
     * Compares the current object with the specified object.
     *
     * @param self $other The object to compare with.
     *
     * @return int Returns a negative integer, zero, or a positive integer depending
     *             on whether the current object is less than, equal to, or greater than
     *             the specified object.
     * @throws InvalidArgumentException If the specified object is not an instance of self.
     */
    #[Override]
    public function compare(IComparable $other): int
    {
        if (!$other instanceof self) {
            throw new InvalidArgumentException('Compared object ' . get_class($other) . ' is not ' . self::class . '.');
        }
        return $this->order() <=> $other->order();
    }
}
