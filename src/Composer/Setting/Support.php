<?php

declare(strict_types=1);

/**
 * Copyright ©2023 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Composer\Setting;

use Graywings\Etter\Etter;
use Graywings\Etter\Get;

/**
 * Project support information
 *
 * @category Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Temp\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read string $email Email address to support.
 * @property-read string $issue URL to the issue tracker.
 * @property-read string $forum URL to the forum.
 * @property-read string $wiki URL to the wiki.
 * @property-read string $irc IRC channel for support, as irc://server/channel.
 * @property-read string $source URL to browse or download the sources.
 * @property-read string $docs URL to the documentation.
 * @property-read string $rss URL to the RSS feed.
 * @property-read string $chat URL to the chat channel.
 * @property-read string $security URL to the vulnerability disclosure policy(VDP).
 */
readonly class Support
{
    use Etter;

    public function __construct(
        #[Get] private string $email,
        #[Get] private string $issue,
        #[Get] private string $forum,
        #[Get] private string $wiki,
        #[Get] private string $irc,
        #[Get] private string $source,
        #[Get] private string $docs,
        #[Get] private string $rss,
        #[Get] private string $chat,
        #[Get] private string $security
    )
    {
    }
}
