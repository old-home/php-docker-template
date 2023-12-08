<?php

declare(strict_types=1);

/**
 * Copyright ©2023 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Temp
 * @package  Graywings\PhpDockerTemplate\Temp
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

namespace Graywings\PhpDockerTemplate\Composer\Setting;

use Graywings\Etter\Etter;
use Graywings\Etter\Get;
use Graywings\PhpDockerTemplate\Version\SemVer\StabilityType;
use Graywings\PhpDockerTemplate\Version\SemVer\Version;

/**
 * Composer Setting for composer.json
 *
 * @category Graywings\PhpDockerTemplate\Temp
 * @package  Graywings\PhpDockerTemplate\Temp
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read PackageName $packageName
 * @property-read string $description
 * @property-read Version $version
 * @property-read PackageType $packageType
 * @property-read string[] $keywords
 * @property-read string $homepage
 * @property-read string $readme
 * @property-read string $time
 * @property-read Author[] $authors
 * @property-read Fund[] $funding
 * @property-read RequirePackage[] $require
 * @property-read RequirePackage[] $requireDev
 * @property-read AutoloadMap[] $autoload
 * @property-read StabilityType $minimumStability
 */
readonly class Setting
{
    use Etter;

    /**
     * @param PackageName $name
     * @param string $description
     * @param Version $version
     * @param PackageType $packageType
     * @param string[] $keywords
     * @param string $homepage
     * @param string $readme
     * @param string $time
     * @param Author[] $authors
     * @param Fund[] $funding
     * @param RequirePackage[] $require
     * @param RequirePackage[] $requireDev
     * @param AutoloadMap[] $autoload
     * @param StabilityType $minimumStability
     */
    public function __construct(
        #[Get] private PackageName   $name,
        #[Get] private string        $description,
        #[Get] private Version       $version,
        #[Get] private PackageType   $packageType,
        #[Get] private array         $keywords,
        #[Get] private string        $homepage,
        #[Get] private string        $readme,
        #[Get] private string        $time,
        #[Get] private array         $authors,
        #[Get] private array         $funding,
        #[Get] private array         $require,
        #[Get] private array         $requireDev,
        #[Get] private array         $autoload,
        #[Get] private StabilityType $minimumStability
    )
    {
    }
}
