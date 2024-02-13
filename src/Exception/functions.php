<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @author  Taira Terashima <taira.terashima@gmail.com>
 * @license MIT https://opensource.org/licenses/MIT
 * @link    https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\Exception;

use ErrorException;

if (!function_exists('Graywings\Exception\initErrorHandler')) {
    /**
     * Set E_* PHP Error handler
     *
     * @return void
     * @throws ErrorException
     */
    function initErrorHandler(): void
    {
        set_error_handler(callback: function (
            int $severity,
            string $message,
            string $file,
            int $line
        ): bool|callable {
            throw new ErrorException(
                $message,
                0,
                $severity,
                $file,
                $line
            );
        });
    }
}
