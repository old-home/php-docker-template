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

use Graywings\Etter\Etter;
use Graywings\Etter\Get;
use Graywings\PhpDockerTemplate\Comparator\Comparator;
use Graywings\PhpDockerTemplate\Comparator\IComparable;
use InvalidArgumentException;
use Override;

/**
 * Version object
 *
 * @category Graywings\PhpDockerTemplate\Temp\Version\SemVer
 * @package  Graywings\PhpDockerTemplate\Temp\Version\SemVer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read int       $major
 * @property-read int|null  $minor
 * @property-read int|null  $patch1
 * @property-read int|null  $patch2
 * @property-read Stability $stability
 */
final readonly class Version
    implements IComparable
{
    use Etter;

    public function __construct(
        #[Get]
        private int       $major,
        #[Get]
        private int|null  $minor,
        #[Get]
        private int|null  $patch1,
        #[Get]
        private int|null  $patch2,
        #[Get]
        private Stability $stability
    ) {}

    public function __clone()
    {
        $this->stability = clone $this->stability;
    }

    public static function parse(string $version): self
    {
        $exploded = explode(
            '-',
            $version
        );
        $versionNumbers = explode(
            '.',
            ltrim(
                $exploded[0],
                'v'
            )
        );
        return new self(
            (int)$versionNumbers[0],
            array_key_exists(
                1,
                $versionNumbers
            ) ? (int)$versionNumbers[1] : null,
            array_key_exists(
                2,
                $versionNumbers
            ) ? (int)$versionNumbers[2] : null,
            array_key_exists(
                3,
                $versionNumbers
            ) ? (int)$versionNumbers[3] : null,
            Stability::parse(
                array_key_exists(
                    1,
                    $exploded
                ) ? $exploded[1] : ''
            )
        );
    }

    public function next(): self
    {
        $versionNumbers = [];
        foreach (VersionLevel::iterator() as $level) {
            if ($this->lowestLevel() === $level) {
                $versionNumbers[] = $this->{$level->value} + 1;
            } else {
                $versionNumbers[] = $this->{$level->value};
            }
        }
        return new Version(
            $versionNumbers[0],
            $versionNumbers[1],
            $versionNumbers[2],
            $versionNumbers[3],
            new Stability(
                StabilityType::DEV,
                1
            )
        );
    }

    public function nextSignificant():self {
        $versionNumbers = [];
        foreach (VersionLevel::iterator() as $level) {
            if ($this->lowestLevel()->prior() === $level) {
                $versionNumbers[] = $this->{$level->value} + 1;
            } else if (Comparator::lessThanEqual($level, $this->lowestLevel())) {
                if ($this->{$level->value} === null) {
                    $versionNumbers[] = null;
                } else {
                    $versionNumbers[] = 0;
                }
            } else if (Comparator::greaterThan($level, $this->lowestLevel())) {
                $versionNumbers[] = $this->{$level->value};
            }
        }
        return new Version(
            $versionNumbers[0],
            $versionNumbers[1],
            $versionNumbers[2],
            $versionNumbers[3],
            new Stability(
                StabilityType::DEV,
                1
            )
        );
    }

    public function nextMajor(): self {
        return new Version(
            $this->major + 1,
            $this->minor ? 0 : null,
            $this->patch1 ? 0 : null,
            $this->patch2 ? 0 : null,
            new Stability(
                StabilityType::DEV,
                1
            )
        );
    }

    /**
     * Returns the lowest level of the version.
     *
     * @return VersionLevel The lowest level of the version.
     */
    public function lowestLevel(): VersionLevel
    {
        foreach (VersionLevel::iterator() as $level) {
            if ($this->{$level->value} === null) {
                return $level->prior();
            }
        }

        return VersionLevel::PATCH2;
    }

    /**
     * Returns a boolean indicating whether the major version has been released.
     *
     * @return bool True if the major version is greater than 0, false otherwise.
     */
    public function majorReleased(): bool
    {
        return $this->major > 0;
    }

    /**
     * Compare the current object with another object.
     *
     * @param self $other The object to compare with.
     *
     * @return int Returns a negative integer if this object is less than the other object,
     *             zero if they are equal, or a positive integer if this object is greater
     *             than the other object.
     *
     */
    #[Override]
    public function compare(IComparable $other): int
    {
        if (!$other instanceof self) {
            throw new InvalidArgumentException('Compared object ' . get_class($other) . ' is not ' . self::class . '.');
        }

        foreach (VersionLevel::iterator() as $versionLevel) {
            $diff = $this->compareVersionParts(
                $other,
                $versionLevel
            );
            if ($diff !== 0) {
                return $diff;
            }
        }

        return $this->stability->compare($other->stability);
    }

    /**
     * Compare the version parts of the current object with another object.
     *
     * @param self         $other
     * @param VersionLevel $versionLevel
     *
     * @return int Returns a negative integer if this object's version parts are less than the other object's version
     *             parts, zero if they are equal, or a positive integer if this object's version parts are greater than
     *             the other object's version parts.
     *
     * @throws InvalidArgumentException if the $other object is not an instance of the same class as the current
     *                                  object.
     */
    public function compareVersionParts(
        self         $other,
        VersionLevel $versionLevel
    ): int
    {
        if ($this->{$versionLevel->value} === null) {
            $selfParts = 0;
        } else {
            $selfParts = (int)$this->{$versionLevel->value};
        }

        if ($other->{$versionLevel->value} === null) {
            $otherParts = 0;
        } else {
            $otherParts = (int)$other->{$versionLevel->value};
        }
        return $selfParts - $otherParts;
    }
}
