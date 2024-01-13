<?php

declare(strict_types=1);

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

namespace Graywings\PhpDockerTemplate\Version\SemVer\Constraint;

use RuntimeException;
use function PHPUnit\Framework\matches;

/**
 * Version constraint parser
 *
 * @category Graywings\PhpDockerTemplate\Version\SemVer\Constraint
 * @package  Graywings\PhpDockerTemplate\Version\SemVer\Constraint
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
class Parser
{
    const string REG_CONSTRAINT_FIRST_CHAR = '/^[~=^]$/';
    const string REG_THAN_CHAR = '/^[<>]$/';
    private array $versionCharacters;
    private ParserState $mode = ParserState::START;
    private string $buffer = '';
    /**
     * @var array<int, Token> $tokens
     */
    private array $tokens = [];

    /**
     * @param string $version
     *
     * @return Tokens
     */
    public function parse(string $version): Tokens
    {
        $this->init();
        $this->versionCharacters = str_split($version);
        while (true) {
            $char = $this->next();
            if (!$this->transition($char)) {
                break;
            }
            $this->buffer .= $char;
        }
        return new Tokens(
            $this->tokens
        );
    }

    private function init(): void
    {
        $this->mode = ParserState::START;
        $this->buffer = '';
        $this->tokens = [];
    }

    private function next(): string|null
    {
        return array_shift($this->versionCharacters);
    }

    private function transition(string|null $char): bool
    {
        return match ($this->mode) {
            ParserState::START => $this->transitionFromStart($char),
            ParserState::THAN => $this->transitionFromThan($char),
            ParserState::CONSTRAINT_CHAR => $this->transitionFromConstraintChar($char),
            ParserState::VERSION_NUMBER => $this->transitionFromNumber($char),
            ParserState::VERSION_DOT => $this->transitionFromDot($char),
            ParserState::AND => $this->transitionFromAnd($char),
            ParserState::SPACE => $this->transitionFromSpace($char),
            ParserState::HYPHEN => $this->transitionFromHyphen($char),
            ParserState::OR => $this->transitionFromOr($char),
            ParserState::VERSION_ASTERISK => $this->transitionFromAsterisk($char),
            ParserState::END => false,
        };
    }

    private function pushToken(
        TokenType $type,
        string    $content
    ): void
    {
        $this->tokens[] = new Token(
            $type,
            $content
        );
        $this->buffer = '';
    }

    private function transitionFromStart(?string $char): true
    {
        $this->buffer = '';
        if (preg_match(
            self::REG_THAN_CHAR,
            $char
        )) {
            $this->mode = ParserState::THAN;
        } else if (is_numeric($char)) {
            $this->mode = ParserState::VERSION_NUMBER;
        } else if (preg_match(
            self::REG_CONSTRAINT_FIRST_CHAR,
            $char
        )) {
            $this->mode = ParserState::CONSTRAINT_CHAR;
        } else {
            throw new RuntimeException;
        }
        return true;
    }

    private function transitionFromThan(?string $char): true
    {
        if ($char === '=') {
            $this->mode = ParserState::CONSTRAINT_CHAR;
        } else if (is_numeric($char)) {
            $this->pushToken(
                TokenType::CONSTRAINT,
                $this->buffer
            );
            $this->mode = ParserState::VERSION_NUMBER;
        } else {
            throw new RuntimeException;
        }
        return true;
    }

    private function transitionFromConstraintChar(?string $char): true
    {
        if (is_numeric($char)) {
            $this->pushToken(
                TokenType::CONSTRAINT,
                $this->buffer
            );
            $this->mode = ParserState::VERSION_NUMBER;
        } else {
            throw new RuntimeException;
        }
        return true;
    }

    private function transitionFromNumber(?string $char): true
    {
        if (!is_numeric($char)) {
            if ($char === ' ' || $char === ',') {
                $this->pushToken(
                    TokenType::VERSION,
                    $this->buffer
                );
                $this->mode = ParserState::AND;
            } else if ($char === '.') {
                $this->mode = ParserState::VERSION_DOT;
            } else if ($char === null) {
                $this->pushToken(
                    TokenType::VERSION,
                    $this->buffer
                );
                $this->mode = ParserState::END;
            } else {
                throw new RuntimeException;
            }
        }
        return true;
    }

    private function transitionFromDot(?string $char): true
    {
        if (is_numeric($char)) {
            $this->mode = ParserState::VERSION_NUMBER;
        } else if ($char === '*') {
            $this->mode = ParserState::VERSION_ASTERISK;
        } else {
            throw new RuntimeException;
        }
        return true;
    }

    private function transitionFromAnd(?string $char): true
    {
        if ($char === '-') {
            $this->buffer = '';
            $this->mode = ParserState::HYPHEN;
        } else if ($char === '|') {
            $this->buffer = '';
            $this->mode = ParserState::OR;
        } else if (preg_match(
            self::REG_THAN_CHAR,
            $char
        )) {
            $this->pushToken(
                TokenType::AND,
                ''
            );
            $this->mode = ParserState::THAN;
        } else {
            throw new RuntimeException;
        }
        return true;
    }

    private function transitionFromHyphen(?string $char): true
    {
        $this->pushToken(
            TokenType::HYPHEN,
            ''
        );
        if ($char === ' ') {
            $this->mode = ParserState::SPACE;
        } else {
            throw new RuntimeException;
        }
        return true;
    }

    private function transitionFromSpace(?string $char): true
    {
        if ($char === '|') {
            $this->buffer = '';
            $this->mode = ParserState::OR;
        } else if (is_numeric($char)) {
            $this->buffer = '';
            $this->mode = ParserState::VERSION_NUMBER;
        } else {
            throw new RuntimeException;
        }
        return true;
    }

    private function transitionFromOr(?string $char): true
    {
        if ($char !== '|') {
            if ($this->buffer === '||') {
                $this->pushToken(
                    TokenType::OR,
                    $this->buffer
                );
                if ($char === ' ') {
                    $this->mode = ParserState::START;
                } else {
                    throw new RuntimeException;
                }
            } else {
                throw new RuntimeException;
            }
        }
        return true;
    }

    private function transitionFromAsterisk(?string $char): true
    {
        $this->pushToken(
            TokenType::ASTERISK_VERSION,
            $this->buffer
        );
        if ($char === null) {
            $this->mode = ParserState::END;
        } else if ($char === ' ') {
            $this->mode = ParserState::SPACE;
        } else {
            throw new RuntimeException;
        }
        return true;
    }
}
