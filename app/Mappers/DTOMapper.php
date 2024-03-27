<?php

namespace App\Mappers;

use Illuminate\Http\Request;
use ReflectionClass;
use ReflectionParameter;


class DTOMapper
{
    public static function mapRequestToDTO(Request $request, string $dtoClassName)
    {
        // Get request data
        $requestData = $request->all();

        // Create a new instance of the DTO class
        $reflection = new ReflectionClass($dtoClassName);
        $constructor = $reflection->getConstructor();
        $constructorParams = $constructor ? $constructor->getParameters() : [];

        // Prepare constructor arguments
        $args = [];
        foreach ($constructorParams as $param) {
            $paramName = $param->getName();
            if (array_key_exists($paramName, $requestData)) {
                $args[$paramName] = $requestData[$paramName];
                unset($requestData[$paramName]);
            } elseif ($param->isDefaultValueAvailable()) {
                $args[$paramName] = $param->getDefaultValue();
            } else {
                throw new \InvalidArgumentException("Missing constructor argument: $paramName");
            }
        }
        // dd($args);
        $constructorArgs = array_values($args);
        try {
            $dtoInstance = $reflection->newInstanceArgs($constructorArgs);
        } catch (\Throwable $e) {
            throw new \RuntimeException("Error instantiating DTO class: " . $e->getMessage());
        }
        if (!is_object($dtoInstance)) {
            throw new \RuntimeException("DTO instance is not an object.");
        }

        // foreach ($propertyValues as $propertyName => $propertyValue) {
        //     $dtoInstance->{$propertyName} = $propertyValue;
        // }

        return $dtoInstance;
    }
}
