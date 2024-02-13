<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Temp\Version\SemVer
 * @package  Graywings\PhpDockerTemplate\Temp\Version\SemVer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Version\SemVer;

use Graywings\PhpDockerTemplate\Comparator\IComparable;
use LogicException;
use Override;

/**
 * Version's level
 *
 * @category Graywings\PhpDockerTemplate\Temp\Version\SemVer
 * @package  Graywings\PhpDockerTemplate\Temp\Version\SemVer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @implements IComparable<VersionLevel>
 */
enum VersionLevel: string implements IComparable
{
    case MAJOR  = 'major';
    case MINOR  = 'minor';
    case PATCH1 = 'patch1';
    case PATCH2 = 'patch2';

    /**
     * Returns the iterator array.
     *
     * @return array<int, self> The array containing the iterator values.
     */
    public static function iterator(): array
    {
        return [
            self::MAJOR,
            self::MINOR,
            self::PATCH1,
            self::PATCH2,
        ];
    }

    /**
     * Returns the prior version of the current version.
     *
     * @return self The prior version of the current version.
     * @throws LogicException if the current version is the MAJOR version.
     */
    public function prior(): self
    {
        return match ($this) {
            self::MAJOR => throw new LogicException(),
            self::MINOR => self::MAJOR,
            self::PATCH1 => self::MINOR,
            self::PATCH2 => self::PATCH1
        };
    }

    #[Override]
    public function compare(IComparable $other): int
    {
        return match ($this) {
            self::MAJOR => match ($other) {
                self::MAJOR => 0,
                self::MINOR => 1,
                self::PATCH1 => 2,
                self::PATCH2 => 3
            },
            self::MINOR => match ($other) {
                self::MAJOR => -1,
                self::MINOR => 0,
                self::PATCH1 => 1,
                self::PATCH2 => 2
            },
            self::PATCH1 => match ($other) {
                self::MAJOR => -2,
                self::MINOR => -1,
                self::PATCH1 => 0,
                self::PATCH2 => 1
            },
            self::PATCH2 => match ($other) {
                self::MAJOR => -3,
                self::MINOR => -2,
                self::PATCH1 => -1,
                self::PATCH2 => 0
            }
        };
    }
}
