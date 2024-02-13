<?php

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

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Composer\Setting;

use Graywings\Etter\Etter;
use Graywings\Etter\Get;
use Graywings\PhpDockerTemplate\Version\SemVer\StabilityType;
use Graywings\PhpDockerTemplate\Version\SemVer\Version;
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
 * @property-read PackageName $name
 * @property-read string $description
 * @property-read Version $version
 * @property-read PackageType $type
 * @property-read string[] $keywords
 * @property-read string $homepage
 * @property-read string $readme
 * @property-read string $time
 * @property-read SoftwareLicense $license
 * @property-read Author[] $authors
 * @property-read Fund[] $funding
 * @property-read RequirePackage[] $require
 * @property-read AutoloadMap[] $autoload
 * @property-read StabilityType $minimumStability
 */
readonly class Setting implements JsonSerializable
{
    use Etter;

    /**
     * Setting constructor
     *
     * @param PackageName $name
     * @param string $description
     * @param RequirePackage[] $require
     * @param ?Version $version
     * @param ?PackageType $type
     * @param ?SoftwareLicense $license
     * @param string[] $keywords
     * @param string $homepage
     * @param string $readme
     * @param string $time
     * @param Author[] $authors
     * @param Fund[] $funding
     * @param AutoloadMap[] $autoload
     * @param ?StabilityType $minimumStability
     * @param Support|null $support
     * @param bool $preferStable
     * @param string[] $repositories
     * @param bool $abandoned
     * @param string[] $nonFeatureBranches
     */
    public function __construct(
        #[Get] private PackageName      $name,
        #[Get] private string           $description,
        #[Get] private array            $require,
        #[Get] private ?Version         $version = null,
        #[Get] private ?PackageType     $type = null,
        #[Get] private ?SoftwareLicense $license = null,
        #[Get] private array            $keywords = [],
        #[Get] private string           $homepage = '',
        #[Get] private string           $readme = '',
        #[Get] private string           $time = '',
        #[Get] private array            $authors = [],
        #[Get] private array            $funding = [],
        #[Get] private array            $autoload = [],
        #[Get] private ?StabilityType   $minimumStability = null,
        #[Get] private ?Support         $support = null,
        #[Get] private bool             $preferStable = true,
        #[Get] private array            $repositories = [],
        #[Get] private bool             $abandoned = false,
        #[Get] private array            $nonFeatureBranches = []
    ) {
    }

    /**
     * JSON serialize
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        $authors = [];
        foreach ($this->authors as $author) {
            $authors[] = [
                'name' => $author->userName,
                'email' => $author->email,
            ];
        }
        return [
            'name' => $this->name->projectName(),
            'description' => $this->description,
            'type' => $this->type->value,
            'license' => $this->license->value,
            'authors' => $authors,
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
                ],
            ],
            'autoload' => [
                'psr-4' => [
                    $this->name->namespaceName() . '\\' => 'src/',
                ],
            ],
            'autoload-dev' => [
                'psr-4' => [
                    $this->name->namespaceName() . '\\Tests\\Unit\\' => 'tests/Unit',
                    $this->name->namespaceName() . '\\Tests\\Feature\\' => 'tests/Feature',
                ],
            ],
            'scripts' => [
                'build' => [
                    '@test'
                ],
                'test' => [
                    '@test:units',
                    '@test:feature',
                ],
                'test:units' => 'phpunit --testsuite units --coverage-html=coverage',
                'test:features' => 'phpunit --testsuite features',
            ]
        ];
    }
}
