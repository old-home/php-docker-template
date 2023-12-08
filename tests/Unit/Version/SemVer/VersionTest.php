<?php
declare(strict_types=1);

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Tests\Features\Temp\Version\SemVer
 * @package  Graywings\PhpDockerTemplate\Tests\Features\Temp\Version\SemVer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Tests\Unit\Version\SemVer;

use Graywings\PhpDockerTemplate\Comparator\Comparator;
use Graywings\PhpDockerTemplate\Version\SemVer\Stability;
use Graywings\PhpDockerTemplate\Version\SemVer\StabilityType;
use Graywings\PhpDockerTemplate\Version\SemVer\Version;
use Graywings\PhpDockerTemplate\Version\SemVer\VersionLevel;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Comparator::class)]
#[CoversClass(Stability::class)]
#[CoversClass(StabilityType::class)]
#[CoversClass(Version::class)]
#[CoversClass(VersionLevel::class)]
class VersionTest extends TestCase
{
    public function testConstructor(): void
    {
        $version = new Version(
            1,
            2,
            3,
            4,
            new Stability(
                StabilityType::RELEASE_CANDIDATE,
                2
            )
        );

        self::assertSame(1, $version->major);
        self::assertSame(2, $version->minor);
        self::assertSame(3, $version->patch1);
        self::assertSame(4, $version->patch2);
        self::assertSame(StabilityType::RELEASE_CANDIDATE, $version->stability->type);
        self::assertSame(2, $version->stability->version);
    }
    public function testParseFullVersion(): void
    {
        $version = Version::parse('1.2.3.4-stable');
        self::assertSame(1, $version->major);
        self::assertSame(2, $version->minor);
        self::assertSame(3, $version->patch1);
        self::assertSame(4, $version->patch2);
        self::assertSame(StabilityType::STABLE, $version->stability->type);
        self::assertSame(1, $version->stability->version);
    }

    public function testParseOmitStabilityVersion(): void
    {
        $version = Version::parse('1.2.3.4');
        self::assertSame(1, $version->major);
        self::assertSame(2, $version->minor);
        self::assertSame(3, $version->patch1);
        self::assertSame(4, $version->patch2);
        self::assertSame(StabilityType::STABLE, $version->stability->type);
        self::assertSame(1, $version->stability->version);
    }

    public function testParseSpecifiedStabilityVersion(): void
    {
        $version = Version::parse('1.2.3.4-RC2');
        self::assertSame(1, $version->major);
        self::assertSame(2, $version->minor);
        self::assertSame(3, $version->patch1);
        self::assertSame(4, $version->patch2);
        self::assertSame(StabilityType::RELEASE_CANDIDATE, $version->stability->type);
        self::assertSame(2, $version->stability->version);
    }

    public function testCompare(): void
    {
        $version1 = Version::parse('1.0.0.0');
        $version2 = Version::parse('1.0.0.0-p1');
        $version3 = Version::parse('1.0.0.0-RC3');
        $version4 = Version::parse('1.0.0.0-RC2');
        $version5 = Version::parse('1.0.0.0-stable');
        $version6 = Version::parse('1.0.0.1-beta');
        $version7 = Version::parse('1.0.3.0');
        $version8 = Version::parse('1.2.2.0');
        $version9 = Version::parse('0.1.3.0');
        $version10 = Version::parse('0.1.3.0-RC1');
        $version11 = Version::parse('0.1.3.0-RC');

        self::assertLessThan(0, $version1->compare($version2));
        self::assertGreaterThan(0, $version1->compare($version3));
        self::assertGreaterThan(0, $version3->compare($version4));
        self::assertSame(0, $version1->compare($version5));
        self::assertLessThan(0, $version1->compare($version6));
        self::assertLessThan(0, $version1->compare($version7));
        self::assertLessThan(0, $version7->compare($version8));
        self::assertGreaterThan(0, $version8->compare($version9));
        self::assertSame(0, $version10->compare($version11));
    }

    public function testCompareInvalid(): void
    {
        $version = Version::parse('1.0.0');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Compared object Graywings\PhpDockerTemplate\Version\SemVer\StabilityType is not Graywings\PhpDockerTemplate\Version\SemVer\Version.');
        $version->compare(StabilityType::DEV);
    }

    public function testLowestLevel(): void
    {
        self::assertSame(VersionLevel::MAJOR, Version::parse('1')->lowestLevel());
        self::assertSame(VersionLevel::MINOR, Version::parse('1.2')->lowestLevel());
        self::assertSame(VersionLevel::PATCH1, Version::parse('1.2.3')->lowestLevel());
        self::assertSame(VersionLevel::PATCH2, Version::parse('1.2.3.4')->lowestLevel());
    }

    public function testMajorReleased(): void
    {
        self::assertTrue(Version::parse('1.2.3.4')->majorReleased());
        self::assertFalse(Version::parse('0.1.2.3')->majorReleased());
    }

    public function testNext(): void
    {
        $version = Version::parse('1.0');
        self::assertSame(1, $version->major);
        self::assertSame(0, $version->minor);
        self::assertNull($version->patch1);
        self::assertNull($version->patch2);
        self::assertSame(StabilityType::STABLE, $version->stability->type);
        self::assertSame(1, $version->stability->version);

        $nextVersion = $version->next();
        self::assertSame(1, $nextVersion->major);
        self::assertSame(1, $nextVersion->minor);
        self::assertNull($nextVersion->patch1);
        self::assertNull($nextVersion->patch2);
        self::assertSame(StabilityType::DEV, $nextVersion->stability->type);
        self::assertSame(1, $nextVersion->stability->version);
    }

    public function testNextSignificant(): void
    {
        $version = Version::parse('1.0');
        self::assertSame(1, $version->major);
        self::assertSame(0, $version->minor);
        self::assertNull($version->patch1);
        self::assertNull($version->patch2);
        self::assertSame(StabilityType::STABLE, $version->stability->type);
        self::assertSame(1, $version->stability->version);

        $nextSignificantVersion = $version->nextSignificant();
        self::assertSame(2, $nextSignificantVersion->major);
        self::assertSame(0, $nextSignificantVersion->minor);
        self::assertNull($nextSignificantVersion->patch1);
        self::assertNull($nextSignificantVersion->patch2);
        self::assertSame(StabilityType::DEV, $nextSignificantVersion->stability->type);
        self::assertSame(1, $nextSignificantVersion->stability->version);

        $version2 = Version::parse('2.0.0');
        self::assertSame(2, $version2->major);
        self::assertSame(0, $version2->minor);
        self::assertSame(0, $version2->patch1);
        self::assertNull($version2->patch2);
        self::assertSame(StabilityType::STABLE, $version2->stability->type);
        self::assertSame(1, $version2->stability->version);

        $nextSignificantVersion2 = $version2->nextSignificant();
        self::assertSame(2, $nextSignificantVersion2->major);
        self::assertSame(1, $nextSignificantVersion2->minor);
        self::assertSame(0, $nextSignificantVersion2->patch1);
        self::assertNull($nextSignificantVersion2->patch2);
        self::assertSame(StabilityType::DEV, $nextSignificantVersion2->stability->type);
        self::assertSame(1, $nextSignificantVersion2->stability->version);
    }

    public function testNextMajor(): void
    {
        $version = Version::parse('1.2.3.4');
        self::assertSame(1, $version->major);
        self::assertSame(2, $version->minor);
        self::assertSame(3, $version->patch1);
        self::assertSame(4, $version->patch2);
        self::assertSame(StabilityType::STABLE, $version->stability->type);
        self::assertSame(1, $version->stability->version);

        $nextMajorVersion = $version->nextMajor();
        self::assertSame(2, $nextMajorVersion->major);
        self::assertSame(0, $nextMajorVersion->minor);
        self::assertSame(0, $nextMajorVersion->patch1);
        self::assertSame(0, $nextMajorVersion->patch2);
        self::assertSame(StabilityType::DEV, $nextMajorVersion->stability->type);
        self::assertSame(1, $nextMajorVersion->stability->version);
    }
}
