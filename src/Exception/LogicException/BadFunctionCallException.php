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
 * Exception thrown if a callback refers to an undefined function or if some arguments are missing.
 *
 * @category Graywings\PhpDockerTemplate\Exception\LogicException
 * @package  Graywings\PhpDockerTemplate\Exception\LogicException
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 * @see      https://www.php.net/manual/en/class.badfunctioncallexception.php
 */
class BadFunctionCallException extends \BadFunctionCallException implements Exception
{
}
