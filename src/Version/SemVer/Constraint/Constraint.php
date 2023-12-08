<?php

declare(strict_types=1);

/**
 * Copyright ©2023 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Temp\Version\SemVer\Constraint
 * @package  Graywings\PhpDockerTemplate\Temp\Version\SemVer\Constraint
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Version\SemVer\Constraint;

use Graywings\Etter\Etter;
use Graywings\PhpDockerTemplate\Comparator\Range;
use Graywings\PhpDockerTemplate\Version\SemVer\Version;
use Graywings\PhpDockerTemplate\Version\SemVer\VersionLevel;
use RuntimeException;

/**
 * Version's constraint
 *
 * @category Graywings\PhpDockerTemplate\Version\SemVer\Constraint
 * @package  Graywings\PhpDockerTemplate\Version\SemVer\Constraint
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read Version|null $sup
 * @property-read bool         $supIsMax
 * @property-read Version|null $inf
 * @property-read bool         $infIsMin
 */
class Constraint
{
    use Etter;

    /**
     * @template-use Range<Version>
     */
    use Range;

    /**
     * @param Version|null $sup
     * @param bool         $supIsMax
     * @param Version|null $inf
     * @param bool         $infIsMin
     */
    public function __construct(
        Version|null $sup,
        bool         $supIsMax,
        Version|null $inf,
        bool         $infIsMin
    )
    {
        $this->sup = $sup;
        $this->supIsMax = $supIsMax;
        $this->inf = $inf;
        $this->infIsMin = $infIsMin;
    }

    /**
     * @param Tokens $tokens
     *
     * @return self
     */
    public static function parse(
        Tokens $tokens
    ): self
    {
        $explodeAnd = $tokens->explode(TokenType::AND);
        if (count($explodeAnd) === 2) {
            return self::parseAnd($explodeAnd);
        }

        if (count($explodeAnd) > 2) {
            throw new RuntimeException;
        }
        $explodeHyphen = $tokens->explode(TokenType::HYPHEN);
        if (count($explodeHyphen) === 2) {
            return self::parseHyphen($explodeHyphen);
        }
        if (count($explodeHyphen) > 2) {
            throw new RuntimeException;
        }
        return self::parseSingleConstraint($tokens);
    }

    /**
     * @param Constraint $other
     *
     * @return self
     */
    public function combine(self $other): self
    {
        [
            $sup,
            $supIsMax
        ] = $this->extractSup($other);
        [
            $inf,
            $infIsMin
        ] = $this->extractInf($other);

        return new self(
            $sup,
            $supIsMax,
            $inf,
            $infIsMin
        );
    }

    private function extractSup(self $other): array
    {
        if (
            $this->sup === null && $other->sup === null
        ) {
            throw new RuntimeException;
        }

        if ($this->sup === null) {
            $sup = clone $other->sup;
            $supIsMax = $other->supIsMax;
        } else {
            $sup = clone $this->sup;
            $supIsMax = $this->supIsMax;
        }

        return [
            $sup,
            $supIsMax
        ];
    }

    private function extractInf(self $other): array
    {
        if (
            $this->inf === null && $other->inf === null
        ) {
            throw new RuntimeException;
        }
        if ($this->inf === null) {
            $inf = clone $other->inf;
            $infIsMin = $other->infIsMin;
        } else {
            $inf = clone $this->inf;
            $infIsMin = $this->infIsMin;
        }

        return [
            $inf,
            $infIsMin
        ];
    }

    /**
     * @param array<int, Tokens> $explodeAnd
     *
     * @return self
     */
    private static function parseAnd(array $explodeAnd): self
    {
        return self::buildConstraint($explodeAnd[0])
            ->combine(self::buildConstraint($explodeAnd[1]));
    }

    /**
     * @param array<int, Tokens> $explodeHyphen
     *
     * @return self
     */
    private static function parseHyphen(array $explodeHyphen): self
    {
        $version1 = Version::parse($explodeHyphen[0]->values[0]->contents);
        $version2 = Version::parse($explodeHyphen[1]->values[0]->contents);
        return new self(
            $version2->next(),
            false,
            $version1,
            true
        );
    }

    private static function parseSingleConstraint(Tokens $tokens): self
    {
        $constraintType = $tokens->values[0]->type;
        if ($constraintType === TokenType::CONSTRAINT) {
            return self::buildConstraint($tokens);
        }

        if ($constraintType === TokenType::ASTERISK_VERSION) {
            return self::parseAsterisk($tokens);
        }
        if ($constraintType === TokenType::VERSION) {
            return new self(
                Version::parse($tokens->values[0]->contents),
                true,
                Version::parse($tokens->values[0]->contents),
                true
            );
        }
        // @codeCoverageIgnoreStart
        throw new RuntimeException;
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param Tokens $tokens
     *
     * @return self
     */
    private static function buildConstraint(Tokens $tokens): self
    {
        return match ($tokens->values[0]->contents) {
            '>' => new Constraint(
                null,
                false,
                Version::parse($tokens->values[1]->contents),
                false
            ),
            '>=' => new Constraint(
                null,
                false,
                Version::parse($tokens->values[1]->contents),
                true
            ),
            '<' => new Constraint(
                Version::parse($tokens->values[1]->contents),
                false,
                null,
                false
            ),
            '<=' => new Constraint(
                Version::parse($tokens->values[1]->contents),
                true,
                null,
                false
            ),
            '^' => self::parseCaret($tokens),
            '~' => self::parseTilde($tokens),
            '=' => new Constraint(
                Version::parse($tokens->values[1]->contents),
                true,
                Version::parse($tokens->values[1]->contents),
                true
            ),
            default => throw new RuntimeException,
        };
    }

    private static function parseCaret(Tokens $tokens): self
    {
        $value = Version::parse($tokens->values[1]->contents);
        if ($value->majorReleased()) {
            return new self(
                $value->nextMajor(),
                false,
                $value,
                true
            );
        }
        return new self(
            $value->next(),
            false,
            $value,
            true
        );
    }

    private static function parseTilde(Tokens $tokens): self
    {
        $value = Version::parse($tokens->values[1]->contents);
        if ($value->lowestLevel() === VersionLevel::MAJOR) {
            throw new RuntimeException;
        }
        return new self(
            $value->nextSignificant(),
            false,
            $value,
            true
        );
    }

    private static function parseAsterisk(Tokens $tokens): self
    {
        $asteriskVersion = $tokens->values[0]->contents;
        $version = Version::parse(
            rtrim(
                $asteriskVersion,
                '.*'
            )
        );

        return new self(
            $version->next(),
            false,
            $version,
            true
        );
    }
}
