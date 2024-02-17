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
 * Exception thrown if a value does not adhere to a defined valid data domain.
 *
 * @category Graywings\PhpDockerTemplate\Exception\LogicException
 * @package  Graywings\PhpDockerTemplate\Exception\LogicException
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 * @see      https://www.php.net/manual/en/class.domainexception.php
 */
class DomainException extends \DomainException implements Exception
{
}
