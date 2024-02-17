<?php
declare(strict_types=1);

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Tests\Unit\Version\SemVer\Constraint
 * @package  Graywings\PhpDockerTemplate\Tests\Unit\Version\SemVer\Constraint
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Tests\Unit\Version\SemVer\Constraint;

use Graywings\PhpDockerTemplate\Comparator\Comparator;
use Graywings\PhpDockerTemplate\Exception\LogicException\DomainException;
use Graywings\PhpDockerTemplate\Version\SemVer\Constraint\Constraint;
use Graywings\PhpDockerTemplate\Version\SemVer\Constraint\Constraints;
use Graywings\PhpDockerTemplate\Version\SemVer\Constraint\Parser;
use Graywings\PhpDockerTemplate\Version\SemVer\Constraint\Token;
use Graywings\PhpDockerTemplate\Version\SemVer\Constraint\Tokens;
use Graywings\PhpDockerTemplate\Version\SemVer\Stability;
use Graywings\PhpDockerTemplate\Version\SemVer\StabilityType;
use Graywings\PhpDockerTemplate\Version\SemVer\Version;
use Graywings\PhpDockerTemplate\Version\SemVer\VersionLevel;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @category Graywings\PhpDockerTemplate\Tests\Unit\Version\SemVer\Constraint
 * @package  Graywings\PhpDockerTemplate\Tests\Unit\Version\SemVer\Constraint
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
#[CoversClass(Comparator::class)]
#[CoversClass(Constraints::class)]
#[CoversClass(Constraint::class)]
#[CoversClass(Parser::class)]
#[CoversClass(Stability::class)]
#[CoversClass(StabilityType::class)]
#[CoversClass(Token::class)]
#[CoversClass(Tokens::class)]
#[CoversClass(Version::class)]
#[CoversClass(VersionLevel::class)]
class ConstraintsTest
    extends TestCase
{
    public function testLessThan(): void
    {
        $constraints = Constraints::parse('>1.0.0');
        $constraint = $constraints->values[0];
        self::assertNull($constraint->sup);
        self::assertSame(1, $constraint->inf?->major);
        self::assertSame(0, $constraint->inf?->minor);
        self::assertSame(0, $constraint->inf?->patch1);
        self::assertNull($constraint->inf?->patch2);
        self::assertSame(StabilityType::STABLE, $constraint->inf?->stability->type);
        self::assertSame(1, $constraint->inf?->stability->version);
        self::assertFalse($constraint->infIsMin);
        self::assertTrue($constraints->contains(Version::parse('2.0.0')));
    }

    public function testLessThanEqual(): void
    {
        $constraints = Constraints::parse('>=1.0.0');
        $constraint = $constraints->values[0];

        self::assertNull($constraint->sup);
        self::assertSame(1, $constraint->inf?->major);
        self::assertSame(0, $constraint->inf?->minor);
        self::assertSame(0, $constraint->inf?->patch1);
        self::assertNull($constraint->inf?->patch2);
        self::assertSame(StabilityType::STABLE, $constraint->inf?->stability->type);
        self::assertSame(1, $constraint->inf?->stability->version);
        self::assertTrue($constraint->infIsMin);
    }

    public function testGreaterThan(): void
    {
        $constraints = Constraints::parse('<1.0.0');
        $constraint = $constraints->values[0];
        self::assertNull($constraint->inf);
        self::assertSame(1, $constraint->sup?->major);
        self::assertSame(0, $constraint->sup?->minor);
        self::assertSame(0, $constraint->sup?->patch1);
        self::assertNull($constraint->sup?->patch2);
        self::assertSame(StabilityType::STABLE, $constraint->sup?->stability->type);
        self::assertSame(1, $constraint->sup?->stability->version);
        self::assertFalse($constraint->supIsMax);
        self::assertTrue($constraints->contains(Version::parse('0.999999999.99999')));
    }

    public function testGreaterThanEqual(): void
    {
        $constraints = Constraints::parse('<=1.0.0');
        $constraint = $constraints->values[0];
        self::assertNull($constraint->inf);
        self::assertSame(1, $constraint->sup?->major);
        self::assertSame(0, $constraint->sup?->minor);
        self::assertSame(0, $constraint->sup?->patch1);
        self::assertNull($constraint->sup?->patch2);
        self::assertSame(StabilityType::STABLE, $constraint->sup?->stability->type);
        self::assertSame(1, $constraint->sup?->stability->version);
        self::assertTrue($constraint->supIsMax);
    }

    public function testAndConstraint1(): void
    {
        $constraints = Constraints::parse('>1.0.0 <=1.4.5');
        self::assertFalse($constraints->contains(Version::parse('1.0.0')));
        self::assertTrue($constraints->contains(Version::parse('1.0.1')));
        self::assertTrue($constraints->contains(Version::parse('1.4.5')));
        self::assertFalse($constraints->contains(Version::parse('1.4.6')));
    }

    public function testAndConstraint2(): void
    {
        $constraints = Constraints::parse('>=1.0.0 <1.4.5');
        self::assertFalse($constraints->contains(Version::parse('0.99999.9999')));
        self::assertTrue($constraints->contains(Version::parse('1.0.0')));
        self::assertTrue($constraints->contains(Version::parse('1.0.1')));
        self::assertFalse($constraints->contains(Version::parse('1.4.5')));
        self::assertFalse($constraints->contains(Version::parse('1.4.6')));
    }

    public function testAndConstraint3(): void
    {
        $constraints = Constraints::parse('<1.4.5 >=1.0.0');
        self::assertFalse($constraints->contains(Version::parse('0.99999.9999')));
        self::assertTrue($constraints->contains(Version::parse('1.0.0')));
        self::assertTrue($constraints->contains(Version::parse('1.0.1')));
        self::assertFalse($constraints->contains(Version::parse('1.4.5')));
        self::assertFalse($constraints->contains(Version::parse('1.4.6')));
    }

    public function testOrConstraint(): void
    {
        $constraints = Constraints::parse('1 - 2 || >=3.4.0');
        self::assertFalse($constraints->contains(Version::parse('0.8.9')));
        self::assertTrue($constraints->contains(Version::parse('1.0.0')));
        self::assertTrue($constraints->contains(Version::parse('2.8.9')));
        self::assertFalse($constraints->contains(Version::parse('3.0.0')));
        self::assertFalse($constraints->contains(Version::parse('3.3.9')));
        self::assertTrue($constraints->contains(Version::parse('3.4.0')));
        self::assertTrue($constraints->contains(Version::parse('3.4.1')));
        self::assertTrue($constraints->contains(Version::parse('8.4.1')));
    }

    public function testAsteriskConstraint(): void
    {
        $constraints = Constraints::parse('1.* || >=2.3.0');
        self::assertFalse($constraints->contains(Version::parse('0.9.89')));
        self::assertTrue($constraints->contains(Version::parse('1.0.0')));
        self::assertTrue($constraints->contains(Version::parse('1.9.9')));
        self::assertFalse($constraints->contains(Version::parse('2.0.0')));
        self::assertFalse($constraints->contains(Version::parse('2.2.9')));
        self::assertTrue($constraints->contains(Version::parse('2.3.0')));
        self::assertTrue($constraints->contains(Version::parse('9.13.0')));
    }

    public function testCaretConstraintForMajorVersion(): void
    {
        $constraints = Constraints::parse('^1.2.3');
        self::assertFalse($constraints->contains(Version::parse('1.2.2')));
        self::assertTrue($constraints->contains(Version::parse('1.2.3')));
        self::assertTrue($constraints->contains(Version::parse('1.9.3')));
        self::assertFalse($constraints->contains(Version::parse('2.0.0')));
    }

    public function testCaretConstraintForMinorVersion(): void
    {
        $constraints = Constraints::parse('^0.0.3');
        self::assertFalse($constraints->contains(Version::parse('0.0.2')));
        self::assertTrue($constraints->contains(Version::parse('0.0.3')));
        self::assertTrue($constraints->contains(Version::parse('0.0.3.138')));
        self::assertFalse($constraints->contains(Version::parse('0.0.4')));
    }

    public function testTildeConstraint(): void
    {
        $constraints = Constraints::parse('~1.4.3');
        self::assertFalse($constraints->contains(Version::parse('1.4.2')));
        self::assertTrue($constraints->contains(Version::parse('1.4.3')));
        self::assertTrue($constraints->contains(Version::parse('1.4.103')));
        self::assertFalse($constraints->contains(Version::parse('1.5.0')));
        self::assertFalse($constraints->contains(Version::parse('2.0.0')));
    }

    public function testConstConstraint(): void
    {
        $constraints = Constraints::parse('1.0.0');
        self::assertFalse($constraints->contains(Version::parse('0.9.9.2')));
        self::assertTrue($constraints->contains(Version::parse('1.0.0')));
        self::assertFalse($constraints->contains(Version::parse('1.0.0.12')));
    }

    public function testDoubleAndConstraint(): void
    {
        $this->expectException(DomainException::class);
        Constraints::parse('>1.0.0 >=2.0.0 <2.5.2');
    }

    public function testDoubleHyphenConstraint(): void
    {
        $this->expectException(DomainException::class);
        Constraints::parse('1 - 2 - 3');
    }

    public function testDuplicateSupConstraint(): void
    {
        $this->expectException(RuntimeException::class);
        Constraints::parse('>1.0.0 >=1.2.0');
    }

    public function testDuplicateInfConstraint(): void
    {
        $this->expectException(RuntimeException::class);
        Constraints::parse('<1.0.0 <=2.0.0');
    }

    public function testLackVersionLevelTildeConstraint(): void
    {
        $this->expectException(RuntimeException::class);
        Constraints::parse('~1');
    }
}
