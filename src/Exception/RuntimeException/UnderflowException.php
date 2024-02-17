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
 * Exception thrown when performing an invalid operation on an empty container, such as removing an element.
 *
 * @category Graywings\PhpDockerTemplate\Exception\RuntimeException
 * @package  Graywings\PhpDockerTemplate\Exception\RuntimeException
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 * @see      https://www.php.net/manual/en/class.underflowexception.php
 */
class UnderflowException extends \UnderflowException implements Exception
{
}
