<?php

namespace Vyuldashev\LaravelOpenApi\Builders\Paths\Operation;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement;
use Vyuldashev\LaravelOpenApi\Annotations\Operation as OperationAnnotation;
use Vyuldashev\LaravelOpenApi\RouteInformation;

class OperationBuilder
{
    public function build(RouteInformation $route): OperationAnnotation
    {
        return collect($route->actionAnnotations)
            ->filter(static function ($annotation) {
                return $annotation instanceof OperationAnnotation;
            })
            ->map(static function (OperationAnnotation $annotation) {
                if (! empty($annotation->security)) {
                    $security             = app($annotation->security);
                    $securitySchema       = $security->build();
                    $annotation->security = SecurityRequirement::create()->securityScheme($securitySchema);
                }

                return $annotation;
            })
            ->first();
    }
}
