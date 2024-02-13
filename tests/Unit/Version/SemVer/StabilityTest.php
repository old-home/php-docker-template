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

use DomainException;
use Graywings\PhpDockerTemplate\Version\SemVer\Stability;
use Graywings\PhpDockerTemplate\Version\SemVer\StabilityType;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Stability::class)]
#[CoversClass(StabilityType::class)]
class StabilityTest extends TestCase
{
    public function testParse(): void
    {
        $stability1 = Stability::parse('dev');
        self::assertSame(StabilityType::DEV, $stability1->type);
        self::assertSame(1, $stability1->version);
        $stability2 = Stability::parse('a');
        self::assertSame(StabilityType::ALPHA, $stability2->type);
        self::assertSame(1, $stability2->version);
        $stability3 = Stability::parse('alpha');
        self::assertSame(StabilityType::ALPHA, $stability3->type);
        self::assertSame(1, $stability3->version);
        $stability4 = Stability::parse('b');
        self::assertSame(StabilityType::BETA, $stability4->type);
        self::assertSame(1, $stability4->version);
        $stability5 = Stability::parse('beta');
        self::assertSame(StabilityType::BETA, $stability5->type);
        self::assertSame(1, $stability5->version);
        $stability6 = Stability::parse('RC');
        self::assertSame(StabilityType::RELEASE_CANDIDATE, $stability6->type);
        self::assertSame(1, $stability6->version);
        $stability7 = Stability::parse('stable');
        self::assertSame(StabilityType::STABLE, $stability7->type);
        self::assertSame(1, $stability7->version);
        $stability8 = Stability::parse('patch');
        self::assertSame(StabilityType::PATCH, $stability8->type);
        self::assertSame(1, $stability8->version);
        $stability9 = Stability::parse('pl2');
        self::assertSame(StabilityType::PATCH, $stability9->type);
        self::assertSame(2, $stability9->version);
        $stability10 = Stability::parse('p3');
        self::assertSame(StabilityType::PATCH, $stability10->type);
        self::assertSame(3, $stability10->version);
    }

    public function testParseInvalid(): void
    {
        self::expectException(DomainException::class);
        self::expectExceptionMessage('Stability hello is not supported.');
        Stability::parse('hello');
    }

    public function testCompare(): void
    {
        $stability1 = Stability::parse('dev');
        $stability2 = Stability::parse('alpha');
        $stability3 = Stability::parse('beta');
        $stability4 = Stability::parse('RC');
        $stability5 = Stability::parse('stable');
        $stability6 = Stability::parse('RC1');
        $stability7 = Stability::parse('RC2');

        self::assertLessThan(0, $stability1->compare($stability2));
        self::assertLessThan(0, $stability2->compare($stability3));
        self::assertLessThan(0, $stability3->compare($stability4));
        self::assertLessThan(0, $stability4->compare($stability5));
        self::assertGreaterThan(0, $stability5->compare($stability1));
        self::assertLessThan(0, $stability6->compare($stability7));
    }

    public function testCompareInvalid()
    {
        $stability = Stability::parse('dev');
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Compared object Graywings\PhpDockerTemplate\Version\SemVer\StabilityType is not Graywings\PhpDockerTemplate\Version\SemVer\Stability.');
        $stability->compare(StabilityType::DEV);
    }
}
