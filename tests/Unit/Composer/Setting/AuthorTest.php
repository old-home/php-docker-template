<?php
declare(strict_types=1);

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Tests\Units\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Tests\Units\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Tests\Unit\Composer\Setting;

use Graywings\PhpDockerTemplate\Composer\Setting\Author;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Author::class)]
class AuthorTest extends TestCase
{
    public function testConstructor(): void
    {
        $author = new Author(
            'Taira Terashima',
            'taira.terashima@gmail.com'
        );

        self::assertSame('Taira Terashima', $author->userName);
        self::assertSame('taira.terashima@gmail.com', $author->email);
        self::assertSame('', $author->homepage);
        self::assertSame('', $author->role);

        $detailedAuthor = new Author(
            'Taira Terashima',
            'taira.terashima@gmail.com',
            'https://graywings.com',
            'Administrator'
        );

        self::assertSame('Taira Terashima', $detailedAuthor->userName);
        self::assertSame('taira.terashima@gmail.com', $detailedAuthor->email);
        self::assertSame('https://graywings.com', $detailedAuthor->homepage);
        self::assertSame('Administrator', $detailedAuthor->role);
    }
}
