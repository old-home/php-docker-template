<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Collection\Exception
 * @package  Graywings\PhpDockerTemplate\Collection\Exception
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Collection\Exception;

use Graywings\PhpDockerTemplate\Exception\LogicException\LogicException;

/**
 * Readonly object change exception
 *
 * @category Graywings\PhpDockerTemplate\Collection\Exception
 * @package  Graywings\PhpDockerTemplate\Collection\Exception
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
class ReadonlyCollectionChangeException extends LogicException
{
}
