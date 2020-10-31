<?php

namespace Vyuldashev\LaravelOpenApi\Annotations;

use InvalidArgumentException;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

/**
 * @Annotation
 *
 * @Target({"METHOD"})
 */
class Operation
{
    /** @var string */
    public $id;

    /** @var array<string> */
    public $tags;

    /** @var string */
    public $method;

    /** @var SecuritySchemeFactory */
    public $security;

    public function __construct($values)
    {
        $this->id = $values['id'] ?? null;
        $this->tags = empty($values['tags']) ? null : (\is_array($values['tags']) ? $values['tags'] : [$values['tags']]);
        $this->method = $values['method'] ?? null;
        if (!empty($values['security']))
        {
            $this->security = class_exists($values['security']) ? $values['security'] : app()->getNamespace().'OpenApi\\SecurityScheme\\'.$values['security'];

            if (! is_a($this->security, SecuritySchemeFactory::class, true)) {
                throw new InvalidArgumentException('Factory class must be instance of SecuritySchemeFactory');
            }
        }
    }

}
