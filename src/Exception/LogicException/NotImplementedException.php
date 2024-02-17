<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Exception
 * @package  Graywings\PhpDockerTemplate\Exception
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Exception\LogicException;

use Graywings\PhpDockerTemplate\Exception\Exception;

/**
 * Exception thrown if not implemented function or method use.
 *
 * @category Graywings\PhpDockerTemplate\Exception
 * @package  Graywings\PhpDockerTemplate\Exception
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
class NotImplementedException extends LogicException implements Exception
{
}
