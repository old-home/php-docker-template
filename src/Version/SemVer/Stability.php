<?php

declare(strict_types=1);

/**
 * Copyright ©2023 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Temp\Version\SemVer
 * @package  Graywings\PhpDockerTemplate\Temp\Version\SemVer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Version\SemVer;

use DomainException;
use Graywings\Etter\Etter;
use Graywings\Etter\Get;
use Graywings\PhpDockerTemplate\Comparator\IComparable;
use InvalidArgumentException;
use Override;

/**
 * Stability
 *
 * @category Graywings\PhpDockerTemplate\Temp\Version\SemVer
 * @package  Graywings\PhpDockerTemplate\Temp\Version\SemVer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read StabilityType $type
 * @property-read int           $version
 */
final readonly class Stability
    implements IComparable
{
    use Etter;

    const string REGEX = '/^(\D*)?(\d+)?$/';

    public function __construct(
        #[Get]
        private StabilityType $type,
        #[Get]
        private int $version
    ) {}

    /**
     * Parse the given stability string and create a new Stability object.
     *
     * @param string $version The stability string to parse.
     *
     * @return self Returns a new Stability object created from the parsed version string.
     * @throws DomainException
     */
    public static function parse(string $version): self
    {
        $matches = [];
        preg_match(
            self::REGEX,
            $version,
            $matches
        );
        $stabilityVersion = array_key_exists(
            2,
            $matches
        ) ? (int)$matches[2] : 1;

        return new Stability(
            StabilityType::parse($matches[1]),
            $stabilityVersion
        );
    }

    /**
     * Compare the current object with the given object.
     *
     * @param self $other The object to compare with.
     *
     * @return int Returns a negative value if the current object is less than the given object,
     *             a positive value if the current object is greater than the given object,
     *             and 0 if both objects are equal.
     * @throws InvalidArgumentException If the given object is not an instance of the same class as the current object.
     */
    #[Override]
    public function compare(IComparable $other): int
    {
        if (!$other instanceof self) {
            throw new InvalidArgumentException('Compared object ' . get_class($other) . ' is not ' . self::class . '.');
        }
        $diff = $this->type->compare($other->type);
        if ($diff !== 0) {
            return $diff;
        }

        return $this->version - $other->version;
    }
}
