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
use RangeException;

/**
 * Repository's package name
 *
 * @category Graywings\PhpDockerTemplate\Temp
 * @package  Graywings\PhpDockerTemplate\Temp
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read string $userName
 * @property-read string $packageName
 */
readonly class PackageName
{
    use Etter;

    #[Get]
    private string $userName;

    #[Get]
    private string $packageName;

    public function __construct(
        string $name
    ) {
        if (!preg_match('#^[a-z0-9]([_.-]?[a-z0-9]+)*/[a-z0-9](([_.]|-{1,2})?[a-z0-9]+)*$#', $name)) {
            throw new RangeException('Package name is not matching pattern');
        }
        $parsedPackage = explode('/', $name);
        $this->userName = $parsedPackage[0];
        $this->packageName = $parsedPackage[1];
    }

    public function projectName(): string
    {
        return $this->userName . '/' . $this->packageName;
    }

    public function namespaceName(): string
    {
        return ucwords($this->userName) . '\\' . ucwords($this->packageName);
    }
}
