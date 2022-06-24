<?php

namespace app\core\container;


use ReflectionClass;

class Container implements ContainerInterface
{
    private array $entries = [];

    public function get($id)
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            if (is_callable($entry)) {
                return $entry($this);
            }

            $id = $entry;
        }

        return $this->resolve($id);
    }

    public function has($id): bool
    {
        return isset($this->entries[$id]);
    }

    public function resolve(string $id)
    {
        try {
            $reflectionClass = new ReflectionClass($id);
        } catch(\ReflectionException $e) {
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }

        if (! $reflectionClass->isInstantiable()) {
            throw new \Exception('Class "' . $id . '" is not instantiable');
        }

        // 2. Inspect the constructor of the class
        $constructor = $reflectionClass->getConstructor();

        if (! $constructor) {
            return new $id;
        }

        // 3. Inspect the constructor parameters (dependencies)
        $parameters = $constructor->getParameters();

        if (! $parameters) {
            return new $id;
        }

        // 4. If the constructor parameter is a class then try to resolve that class using the container
        $dependencies = array_map(
            function (\ReflectionParameter $param) use ($id) {
                $name = $param->getName();
                $type = $param->getType();

                if (! $type) {
                    throw new \Exception(
                        'Failed to resolve class "' . $id . '" because param "' . $name . '" is missing a type hint'
                    );
                }

                if ($type instanceof \ReflectionUnionType) {
                    throw new \Exception(
                        'Failed to resolve class "' . $id . '" because of union type for param "' . $name . '"'
                    );
                }

                if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new \Exception(
                    'Failed to resolve class "' . $id . '" because invalid param "' . $name . '"'
                );
            },
            $parameters
        );

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}