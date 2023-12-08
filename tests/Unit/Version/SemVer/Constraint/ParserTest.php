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

use Graywings\PhpDockerTemplate\Version\SemVer\Constraint\Parser;
use Graywings\PhpDockerTemplate\Version\SemVer\Constraint\Token;
use Graywings\PhpDockerTemplate\Version\SemVer\Constraint\Tokens;
use Graywings\PhpDockerTemplate\Version\SemVer\Constraint\TokenType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RuntimeException;

#[CoversClass(Parser::class)]
#[CoversClass(Token::class)]
#[CoversClass(Tokens::class)]
class ParserTest
    extends TestCase
{
    public function testParse(): void
    {
        $parser = new Parser;
        $tokens = $parser->parse('<1.0.0')->values;
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[0]->type
        );
        self::assertSame(
            '<',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[1]->type
        );
        self::assertSame(
            '1.0.0',
            $tokens[1]->contents
        );

        $tokens = $parser->parse('>=1.0')->values;
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[0]->type
        );
        self::assertSame(
            '>=',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[1]->type
        );
        self::assertSame(
            '1.0',
            $tokens[1]->contents
        );

        $tokens = $parser->parse('>=1.0 <2.0')->values;
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[0]->type
        );
        self::assertSame(
            '>=',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[1]->type
        );
        self::assertSame(
            '1.0',
            $tokens[1]->contents
        );
        self::assertSame(
            TokenType::AND,
            $tokens[2]->type
        );
        self::assertSame(
            '',
            $tokens[2]->contents
        );
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[3]->type
        );
        self::assertSame(
            '<',
            $tokens[3]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[4]->type
        );
        self::assertSame(
            '2.0',
            $tokens[4]->contents
        );

        $tokens = $parser->parse('>=1.0 <1.1 || >=1.2')->values;
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[0]->type
        );
        self::assertSame(
            '>=',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[1]->type
        );
        self::assertSame(
            '1.0',
            $tokens[1]->contents
        );
        self::assertSame(
            TokenType::AND,
            $tokens[2]->type
        );
        self::assertSame(
            '',
            $tokens[2]->contents
        );
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[3]->type
        );
        self::assertSame(
            '<',
            $tokens[3]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[4]->type
        );
        self::assertSame(
            '1.1',
            $tokens[4]->contents
        );
        self::assertSame(
            TokenType::OR,
            $tokens[5]->type
        );
        self::assertSame(
            '||',
            $tokens[5]->contents
        );
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[6]->type
        );
        self::assertSame(
            '>=',
            $tokens[6]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[7]->type
        );
        self::assertSame(
            '1.2',
            $tokens[7]->contents
        );

        $tokens = $parser->parse('1 - 2')->values;
        self::assertSame(
            TokenType::VERSION,
            $tokens[0]->type
        );
        self::assertSame(
            '1',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::HYPHEN,
            $tokens[1]->type
        );
        self::assertSame(
            '',
            $tokens[1]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[2]->type
        );
        self::assertSame(
            '2',
            $tokens[2]->contents
        );

        $tokens = $parser->parse('1.0 - 2.0')->values;
        self::assertSame(
            TokenType::VERSION,
            $tokens[0]->type
        );
        self::assertSame(
            '1.0',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::HYPHEN,
            $tokens[1]->type
        );
        self::assertSame(
            '',
            $tokens[1]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[2]->type
        );
        self::assertSame(
            '2.0',
            $tokens[2]->contents
        );

        $tokens = $parser->parse('1 - 2 || >=2.3')->values;
        self::assertSame(
            TokenType::VERSION,
            $tokens[0]->type
        );
        self::assertSame(
            '1',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::HYPHEN,
            $tokens[1]->type
        );
        self::assertSame(
            '',
            $tokens[1]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[2]->type
        );
        self::assertSame(
            '2',
            $tokens[2]->contents
        );
        self::assertSame(
            TokenType::OR,
            $tokens[3]->type
        );
        self::assertSame(
            '||',
            $tokens[3]->contents
        );
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[4]->type
        );
        self::assertSame(
            '>=',
            $tokens[4]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[5]->type
        );
        self::assertSame(
            '2.3',
            $tokens[5]->contents
        );

        $tokens = $parser->parse('1.0.*')->values;
        self::assertSame(
            TokenType::ASTERISK_VERSION,
            $tokens[0]->type
        );
        self::assertSame(
            '1.0.*',
            $tokens[0]->contents
        );

        $tokens = $parser->parse('~1.0')->values;
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[0]->type
        );
        self::assertSame(
            '~',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[1]->type
        );
        self::assertSame(
            '1.0',
            $tokens[1]->contents
        );

        $tokens = $parser->parse('^1.12.3')->values;
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[0]->type
        );
        self::assertSame(
            '^',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[1]->type
        );
        self::assertSame(
            '1.12.3',
            $tokens[1]->contents
        );

        $tokens = $parser->parse('^0.3')->values;
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[0]->type
        );
        self::assertSame(
            '^',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[1]->type
        );
        self::assertSame(
            '0.3',
            $tokens[1]->contents
        );

        $tokens = $parser->parse('^0.0.3')->values;
        self::assertSame(
            TokenType::CONSTRAINT,
            $tokens[0]->type
        );
        self::assertSame(
            '^',
            $tokens[0]->contents
        );
        self::assertSame(
            TokenType::VERSION,
            $tokens[1]->type
        );
        self::assertSame(
            '0.0.3',
            $tokens[1]->contents
        );
    }

    public function testFailParseFromStart(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse(' ');
    }

    public function testFailParseFromThan(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse('>|');
    }

    public function testFailParseFromConstraintChar(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse('~|');
    }

    public function testFailParseFromNumber(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse('>1|');
    }

    public function testFailParseFromDot(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse('>1.|');
    }

    public function testFailParseFromAnd(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse('>1.0.0 1');
    }

    public function testFailParseFromHyphen(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse('1 -2');
    }

    public function testFailParseFromSpace(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse('1 - .');
    }

    public function testFailParseFromOr(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse('1 ||2');
    }

    public function testFailParseFromAsterisk(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse('1.0.*.2');
    }

    public function testTooMuchOr(): void
    {
        $this->expectException(RuntimeException::class);
        (new Parser())->parse('1 - 2 ||| 3.*');
    }
}
