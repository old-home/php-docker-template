<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Composer\Setting\Config
 * @package  Graywings\PhpDockerTemplate\Composer\Setting\Config
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Composer\Setting\Config;

use JsonSerializable;
use Override;

/**
 * Security audit
 *
 * @category Graywings\PhpDockerTemplate\Composer\Setting\Config
 * @package  Graywings\PhpDockerTemplate\Composer\Setting\Config
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 *
 * @property-read string[] $ignore
 * @property-read string[] $report
 * @property-read string[] $fail
 */
readonly class Audit implements JsonSerializable
{
    /**
     * Audit constructor
     *
     * @param string[] $ignore
     * @param string[] $report
     * @param string[] $fail
     */
    public function __construct(
        private array $ignore,
        private array $report,
        private array $fail
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
        return [
            'ignore' => $this->ignore,
            'report' => $this->report,
            'fail'   => $this->fail
        ];
    }
}
