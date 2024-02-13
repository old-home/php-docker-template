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

use JsonSerializable;
use Override;
use PHPUnit\Util\Json;

/**
 * Software License
 *
 * @category Graywings\PhpDockerTemplate\Temp
 * @package  Graywings\PhpDockerTemplate\Temp
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
enum SoftwareLicense: string implements JsonSerializable
{
    case MIT = 'MIT';
    case BSD = 'BSD';
    case WTFPL = 'WTFPL';
    case ISC = 'ISC';
    case GPL = 'GPL';
    case LGPL = 'LGPL';
    case APACHE = 'Apache';
    case CC_0_1_0 = 'CC0.1.0';
    case PUBLIC_DOMAIN = 'Public Domain';
    case PROPRIETARY = 'Proprietary';

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
