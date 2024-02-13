<?php

/**
 * Copyright ©2024 Graywings. All rights reserved.
 *
 * PHP version >= 8.3.0
 *
 * @category Graywings\PhpDockerTemplate\Serializer
 * @package  Graywings\PhpDockerTemplate\Serializer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */

declare(strict_types=1);

namespace Graywings\PhpDockerTemplate\Serializer;

use Exception;
use Graywings\PhpDockerTemplate\Str\CaseType;
use Graywings\PhpDockerTemplate\Str\Str;
use ReflectionClass;
use ReflectionNamedType;

/**
 * Simple json serializer
 *
 * @category Graywings\PhpDockerTemplate\Serializer
 * @package  Graywings\PhpDockerTemplate\Serializer
 * @author   Taira Terashima <taira.terashima@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/old-home/php-docker-template
 */
trait SimpleJsonSerializer
{
    /**
     * Define exclude parameters when serialize JSON
     *
     * @var array<int, string> exclude
     */
    protected array $exclude = [];

    /**
     * Json serialize
     *
     * @param  CaseType $before
     * @param  CaseType $after
     * @return array<string, mixed>
     */
    public function jsonSerialize(
        CaseType $before = CaseType::LOWER_CAMEL,
        CaseType $after = CaseType::KEBAB
    ): array {
        $ret = [];
        $reflectionClass = new ReflectionClass($this);
        $reflectionProperties = $reflectionClass->getProperties();
        $this->exclude[] = 'exclude';

        foreach ($reflectionProperties as $reflectionProperty) {
            if (
                !in_array(
                    $reflectionProperty->name,
                    $this->exclude,
                    true
                )
            ) {
                $kebabName = Str::changeCase(
                    $reflectionProperty->name,
                    $before,
                    $after
                );
                // TODO: Arrayの中がbuiltinならそのまま突っ込む, オブジェクトならjsonSerialize
                if ($reflectionProperty->isInitialized()) {
                    $propertyType = $reflectionProperty->getType();
                    if ($propertyType === null) {
                        throw new Exception();
                    }
                    if (is_a($propertyType, ReflectionNamedType::class)) {
                        if (!$propertyType->isBuiltin()) {
                            $ret[$kebabName] = $this->${$reflectionProperty->name};
                        } else {
                            $ret[$kebabName] = $this->${$reflectionProperty->name}->jsonSerialize();
                        }
                    } else {
                        throw new Exception();
                    }
                }
            }
        }
        return $ret;
    }
}
