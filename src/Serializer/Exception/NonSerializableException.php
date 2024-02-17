<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Serializer\Exception
 * @package  Graywings\PhpDockerTemplate\Serializer\Exception
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Serializer\Exception;

use Graywings\PhpDockerTemplate\Exception\LogicException\LogicException;

/**
 * Not specified property can't serialize
 *
 * @category Graywings\PhpDockerTemplate\Serializer\Exception
 * @package  Graywings\PhpDockerTemplate\Serializer\Exception
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
class NonSerializableException extends LogicException
{
}
