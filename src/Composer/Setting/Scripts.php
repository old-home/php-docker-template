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

namespace Graywings\PhpDockerTemplate\Composer\Setting;

use Graywings\Etter\Etter;
use Graywings\Etter\Get;
use Graywings\PhpDockerTemplate\Serializer\SimpleJsonSerializer;
use JsonSerializable;
use Override;

/**
 * Composer scripts commands
 *
 * @category Graywings\PhpDockerTemplate\Composer\Setting
 * @package  Graywings\PhpDockerTemplate\Composer\Setting
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
class Scripts implements JsonSerializable
{
    use Etter;
    use SimpleJsonSerializer {
        SimpleJsonSerializer::jsonSerialize as excludedJson;
    }

    /**
     * Scripts constructor
     *
     * @param string[]                $preInstallCmd
     * @param string[]                $postInstallCmd
     * @param string[]                $preUpdateCmd
     * @param string[]                $postUpdateCmd
     * @param string[]                $preStatusCmd
     * @param string[]                $postStatusCmd
     * @param string[]                $preArchiveCmd
     * @param string[]                $postArchiveCmd
     * @param string[]                $preAutoloadCmd
     * @param string[]                $postAutoloadCmd
     * @param string[]                $postRootPackageInstall
     * @param string[]                $postCreateProjectCmd
     * @param string[]                $preOperationsExec
     * @param string[]                $prePackageInstall
     * @param string[]                $postPackageInstall
     * @param string[]                $prePackageUpdate
     * @param string[]                $postPackageUpdate
     * @param string[]                $prePackageUninstall
     * @param string[]                $postPackageUninstall
     * @param string[]                $init
     * @param string[]                $preFileDownload
     * @param string[]                $postFileDownload
     * @param string[]                $prePoolCreate
     * @param string[]                $preCommandRun
     * @param array<string, string[]> $command
     */
    public function __construct(
        #[Get] private readonly array $preInstallCmd = [],
        #[Get] private readonly array $postInstallCmd = [],
        #[Get] private readonly array $preUpdateCmd = [],
        #[Get] private readonly array $postUpdateCmd = [],
        #[Get] private readonly array $preStatusCmd = [],
        #[Get] private readonly array $postStatusCmd = [],
        #[Get] private readonly array $preArchiveCmd = [],
        #[Get] private readonly array $postArchiveCmd = [],
        #[Get] private readonly array $preAutoloadCmd = [],
        #[Get] private readonly array $postAutoloadCmd = [],
        #[Get] private readonly array $postRootPackageInstall = [],
        #[Get] private readonly array $postCreateProjectCmd = [],
        #[Get] private readonly array $preOperationsExec = [],
        #[Get] private readonly array $prePackageInstall = [],
        #[Get] private readonly array $postPackageInstall = [],
        #[Get] private readonly array $prePackageUpdate = [],
        #[Get] private readonly array $postPackageUpdate = [],
        #[Get] private readonly array $prePackageUninstall = [],
        #[Get] private readonly array $postPackageUninstall = [],
        #[Get] private readonly array $init = [],
        #[Get] private readonly array $preFileDownload = [],
        #[Get] private readonly array $postFileDownload = [],
        #[Get] private readonly array $prePoolCreate = [],
        #[Get] private readonly array $command = [],
        #[Get] private readonly array $preCommandRun = []
    ) {
        $this->exclude[] = 'command';
    }

    /**
     * To Json serializable array
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $ret = $this->excludedJson();

        foreach ($this->command as $commandName => $command) {
            $ret[$commandName] = $command;
        }

        return $ret;
    }
}
