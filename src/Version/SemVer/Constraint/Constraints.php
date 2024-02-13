<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Version\SemVer\Constraint
 * @package  Graywings\PhpDockerTemplate\Version\SemVer\Constraint
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Version\SemVer\Constraint;

use Graywings\Etter\Etter;
use Graywings\Etter\Get;
use Graywings\PhpDockerTemplate\Version\SemVer\Version;

/**
 * Version or constraints
 *
 * @category Graywings\PhpDockerTemplate\Version\SemVer\Constraint
 * @package  Graywings\PhpDockerTemplate\Version\SemVer\Constraint
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read array<int, Constraint> $values
 */
class Constraints
{
    use Etter;

    /**
     * Constraints constructor
     *
     * @param array<int, Constraint> $values
     */
    public function __construct(
        #[Get]
        private readonly array $values
    ) {
    }

    /**
     * Parse version constraint string
     *
     * @param string $versionConstraint
     *
     * @return self
     */
    public static function parse(
        string $versionConstraint
    ): self {
        $parser = new Parser();
        $tokens = $parser->parse($versionConstraint);
        $tokensArray = $tokens->explode(TokenType::OR);
        $constraints = [];
        foreach ($tokensArray as $tokens) {
            $constraints[] = Constraint::parse($tokens);
        }
        return new Constraints($constraints);
    }

    public function contains(Version $version): bool
    {
        $result = false;
        foreach ($this->values as $value) {
            $result = $result || $value->contains($version);
        }
        return $result;
    }
}
