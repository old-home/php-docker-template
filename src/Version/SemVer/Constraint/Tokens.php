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

/**
 * Token array object
 *
 * @category Graywings\PhpDockerTemplate\Version\SemVer\Constraint
 * @package  Graywings\PhpDockerTemplate\Version\SemVer\Constraint
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read array<int, Token> $values
 */
readonly class Tokens
{
    use Etter;

    /**
     * Tokens constructor
     *
     * @param array<int, Token> $values
     */
    public function __construct(
        #[Get]
        private array $values
    ) {
    }

    /**
     * Explode tokens by TokenType
     *
     * @param TokenType $type
     *
     * @return array<int, self>
     */
    public function explode(TokenType $type): array
    {
        $tokens = [];
        $tokensArray = [];
        foreach ($this->values as $token) {
            if ($token->type === $type) {
                $tokensArray[] = new Tokens($tokens);
                $tokens = [];
            } else {
                $tokens[] = $token;
            }
        }
        $tokensArray[] = new Tokens($tokens);
        return $tokensArray;
    }
}
