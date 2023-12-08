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
use JsonSerializable;
use Override;

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
readonly class Setting implements JsonSerializable
{
    use Etter;

    /**
     * @param PackageName $name
     * @param string $description
     * @param PackageType $packageType
     * @param SoftwareLicense $license
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
        #[Get] private PackageName     $name,
        #[Get] private string          $description,
        #[Get] private PackageType     $packageType,
        #[Get] private SoftwareLicense $license,
        #[Get] private array           $keywords,
        #[Get] private string          $homepage,
        #[Get] private string          $readme,
        #[Get] private string          $time,
        #[Get] private array           $authors,
        #[Get] private array           $funding,
        #[Get] private array           $require,
        #[Get] private array           $requireDev,
        #[Get] private array           $autoload,
        #[Get] private StabilityType   $minimumStability
    )
    {
    }

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->packageName->projectName(),
            'description' => $this->description,
            'type' => $this->packageType->value,
            'license' => $this->license->value,
            'authors' => $this->authors,
            'minimum-stability' => $this->minimumStability,
            'config' => [
                'platform' => [
                    'php' => '8.3',
                    'ext-ast' => '8.3',
                    'ext-ctype' => '8.3',
                    'ext-iconv' => '8.3',
                    'ext-json' => '8.3',
                    'ext-mbstring' => '8.3',
                    'ext-simplexml' => '8.3',
                    'ext-xml' => '8.3'
                ]
            ],
            'autoload' => [
                'psr-4' => [
                    $this->packageName->namespaceName() . '\\\\' => 'src/'
                ]
            ],
            'autoload-dev' => [
                'psr-4' => [
                    $this->packageName->namespaceName() . '\\\\Tests\\\\Unit\\\\' => 'tests/Unit',
                    $this->packageName->namespaceName() . '\\\\Tests\\\\Feature\\\\' => 'tests/Feature'
                ]
            ],
            'scripts' => [
                'build' => [
                    '@test'
                ],
                'test' => [
                    '@test:units',
                    '@test:feature'
                ],
                'test:units' => 'phpunit --testsuite units --coverage-html=coverage',
                'test:features' => 'phpunit --testsuite features'
            ]
        ];
    }
}
