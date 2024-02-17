<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Exception\LogicException
 * @package  Graywings\PhpDockerTemplate\Exception\LogicException
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Exception\LogicException;

use Graywings\PhpDockerTemplate\Exception\Exception;

/**
 * Exception thrown if an argument is not of the expected type.
 *
 * @category Graywings\PhpDockerTemplate\Exception\LogicException
 * @package  Graywings\PhpDockerTemplate\Exception\LogicException
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 * @see      https://www.php.net/manual/en/class.invalidargumentexception.php
 */
class InvalidArgumentException extends \InvalidArgumentException implements Exception
{
}
