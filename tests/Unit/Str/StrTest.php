<?php
declare(strict_types=1);

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Tests\Feature\Str
 * @package  Graywings\PhpDockerTemplate\Tests\Feature\Str
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Tests\Unit\Str;

use Graywings\PhpDockerTemplate\Str\CaseType;
use Graywings\PhpDockerTemplate\Str\Str;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Str test
 *
 * @category Graywings\PhpDockerTemplate\Tests\Feature\Str
 * @package  Graywings\PhpDockerTemplate\Tests\Feature\Str
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
#[CoversClass(Str::class)]
class StrTest extends TestCase
{
    public function testFromLowerCamel()
    {
        $this->assertSame(
            'helloWorld',
            Str::changeCase(
                'helloWorld',
                CaseType::LOWER_CAMEL,
                CaseType::LOWER_CAMEL
            )
        );
        $this->assertSame(
            'HelloWorld',
            Str::changeCase(
                'helloWorld',
                CaseType::LOWER_CAMEL,
                CaseType::UPPER_CAMEL
            )
        );

        $this->assertSame(
            'HELLO_WORLD',
            Str::changeCase(
                'helloWorld',
                CaseType::LOWER_CAMEL,
                CaseType::SCREAMING_SNAKE
            )
        );

        $this->assertSame(
            'hello_world',
            Str::changeCase(
                'helloWorld',
                CaseType::LOWER_CAMEL,
                CaseType::SNAKE
            )
        );

        $this->assertSame(
            'hello-world',
            Str::changeCase(
                'helloWorld',
                CaseType::LOWER_CAMEL,
                CaseType::KEBAB
            )
        );
    }

    public function testFromUpperCase()
    {
        $this->assertSame(
            'helloWorld',
            Str::changeCase(
                'HelloWorld',
                CaseType::UPPER_CAMEL,
                CaseType::LOWER_CAMEL
            )
        );

        $this->assertSame(
            'HelloWorld',
            Str::changeCase(
                'HelloWorld',
                CaseType::UPPER_CAMEL,
                CaseType::UPPER_CAMEL
            )
        );
    }
}
