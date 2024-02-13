<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Composer\Setting\Config;

use Graywings\Etter\Etter;
use Graywings\Etter\Get;
use Graywings\PhpDockerTemplate\Serializer\SimpleJsonSerializer;
use JsonSerializable;

/**
 * Composer config
 *
 * @category Graywings\PhpDockerTemplate\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
class Config implements JsonSerializable
{
    use Etter;
    use SimpleJsonSerializer;

    /**
     * Config constructor
     *
     * @param int $processTimeout
     * @param bool $allowPlugin
     * @param bool $useIncludePath
     * @param Audit|null $audit
     * @param string|bool $useParentDir
     * @param string|bool $storeAuths
     * @param array<int, string> $githubProtocols
     * @param array<int, string> $githubOauth
     * @param array<int, string> $githubDomains
     * @param bool $githubExposeHostname
     * @param bool $useGithubApi
     * @param array<int, string> $gitlabDomains
     * @param array<int, string> $gitlabOauth
     * @param array<int, string> $gitlabToken
     * @param string $gitlabProtocol
     * @param bool $disableTls
     * @param bool $secureHttp
     * @param array<int, string> $bitbucketOauth
     * @param string $cafile
     * @param string $capath
     * @param array<string, string> $httpBasic
     * @param array<int, string> $bearer
     * @param array<int, string> $platform
     * @param string $vendorDir
     * @param string $binDir
     * @param string $dataDir
     * @param string $cacheDir
     * @param string $cacheFilesDir
     * @param string $cacheRepoDir
     * @param string $cacheVcsDir
     * @param string $archiveDir
     * @param int $cacheFilesTtl
     * @param string $cacheFilesMaxsize
     * @param bool $cacheReadOnly
     * @param string $binCompat
     * @param bool $prependAutoloader
     * @param string|null $autoloaderSuffix
     * @param bool $optimizeAutoloader
     * @param bool $sortPackages
     * @param bool $classmapAuthoritative
     * @param bool $apcuAutoloader
     * @param bool $notifyOnInstall
     * @param string|bool $discardChanges
     * @param string $archiveFormat
     * @param bool $htaccessProtect
     * @param bool $lock
     * @param string|bool $platformCheck
     * @param array<int, string> $secureSvnDomains
     */
    public function __construct(
        #[Get] private readonly int         $processTimeout = 300,
        #[Get] private readonly bool        $allowPlugin = false,
        #[Get] private readonly bool        $useIncludePath = false,
        #[Get] private readonly ?Audit      $audit = null,
        #[Get] private readonly string|bool $useParentDir = 'prompt',
        #[Get] private readonly string|bool $storeAuths = 'prompt',
        #[Get] private readonly array       $githubProtocols = [
            'https',
            'ssh',
            'git',
        ],
        #[Get] private readonly array       $githubOauth = [],
        #[Get] private readonly array       $githubDomains = ['github.com'],
        #[Get] private readonly bool        $githubExposeHostname = true,
        #[Get] private readonly bool        $useGithubApi = true,
        #[Get] private readonly array       $gitlabDomains = ['gitlab.com'],
        #[Get] private readonly array       $gitlabOauth = [],
        #[Get] private readonly array       $gitlabToken = [],
        #[Get] private readonly string      $gitlabProtocol = 'git',
        #[Get] private readonly bool        $disableTls = false,
        #[Get] private readonly bool        $secureHttp = true,
        #[Get] private readonly array       $bitbucketOauth = [],
        #[Get] private readonly string      $cafile = '',
        #[Get] private readonly string      $capath = '',
        #[Get] private readonly array       $httpBasic = [],
        #[Get] private readonly array       $bearer = [],
        #[Get] private readonly array       $platform = [],
        #[Get] private readonly string      $vendorDir = '',
        #[Get] private readonly string      $binDir = '',
        #[Get] private readonly string      $dataDir = '',
        #[Get] private readonly string      $cacheDir = '',
        #[Get] private readonly string      $cacheFilesDir = '',
        #[Get] private readonly string      $cacheRepoDir = '',
        #[Get] private readonly string      $cacheVcsDir = '',
        #[Get] private readonly string      $archiveDir = '',
        #[Get] private readonly int         $cacheFilesTtl = 155552000,
        #[Get] private readonly string      $cacheFilesMaxsize = '300MiB',
        #[Get] private readonly bool        $cacheReadOnly = false,
        #[Get] private readonly string      $binCompat = 'auto',
        #[Get] private readonly bool        $prependAutoloader = true,
        #[Get] private readonly ?string     $autoloaderSuffix = null,
        #[Get] private readonly bool        $optimizeAutoloader = false,
        #[Get] private readonly bool        $sortPackages = false,
        #[Get] private readonly bool        $classmapAuthoritative = false,
        #[Get] private readonly bool        $apcuAutoloader = false,
        #[Get] private readonly bool        $notifyOnInstall = true,
        #[Get] private readonly string|bool $discardChanges = false,
        #[Get] private readonly string      $archiveFormat = 'tar',
        #[Get] private readonly bool        $htaccessProtect = true,
        #[Get] private readonly bool        $lock = true,
        #[Get] private readonly string|bool $platformCheck = 'php-only',
        #[Get] private readonly array       $secureSvnDomains = []
    ) {
    }
}
