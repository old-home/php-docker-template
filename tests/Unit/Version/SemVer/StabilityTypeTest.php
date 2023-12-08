<?php
declare(strict_types=1);

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Tests\Features\Version\SemVer
 * @package  Graywings\PhpDockerTemplate\Tests\Features\Version\SemVer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Tests\Unit\Version\SemVer;

use Graywings\PhpDockerTemplate\Version\SemVer\Stability;
use Graywings\PhpDockerTemplate\Version\SemVer\StabilityType;
use Graywings\PhpDockerTemplate\Version\SemVer\Version;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StabilityType::class)]
#[CoversClass(Stability::class)]
#[CoversClass(Version::class)]
class StabilityTypeTest extends TestCase
{
    public function testCompareStabilityType(): void
    {
        $dev = StabilityType::DEV;
        $alpha = StabilityType::ALPHA;
        $beta = StabilityType::BETA;
        $rc = StabilityType::RELEASE_CANDIDATE;
        $stable = StabilityType::STABLE;
        $patch = StabilityType::PATCH;

        self::assertLessThan(0, $dev->compare($alpha));
        self::assertLessThan(0, $alpha->compare($beta));
        self::assertLessThan(0, $beta->compare($rc));
        self::assertLessThan(0, $rc->compare($stable));
        self::assertLessThan(0, $stable->compare($patch));
        self::assertGreaterThan(0, $patch->compare($dev));
    }

    public function testCompareInvalid(): void
    {
        $dev = StabilityType::DEV;
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Compared object Graywings\PhpDockerTemplate\Version\SemVer\Version is not Graywings\PhpDockerTemplate\Version\SemVer\StabilityType.');
        $dev->compare(Version::parse('1.0.0'));
    }
}
