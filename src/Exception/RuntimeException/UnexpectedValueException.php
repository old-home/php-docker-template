<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Exception\RuntimeException
 * @package  Graywings\PhpDockerTemplate\Exception\RuntimeException
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Exception\RuntimeException;

use Graywings\PhpDockerTemplate\Exception\Exception;

/**
 * Exception thrown if a value does not match with a set of values.
 * Typically, this happens when a function calls another function and
 * expects the return value to be of a certain type or value not including arithmetic or buffer related errors.
 *
 * @category Graywings\PhpDockerTemplate\Exception\RuntimeException
 * @package  Graywings\PhpDockerTemplate\Exception\RuntimeException
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 * @see      https://www.php.net/manual/en/class.unexpectedvalueexception.php
 */
class UnexpectedValueException extends \UnexpectedValueException implements Exception
{
}
