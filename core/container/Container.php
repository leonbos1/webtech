<?php

namespace app\core\container;

use app\core\container\exceptions\ContainerException;
use app\core\container\exceptions\DependencyIsNotInstantiableException;
use app\core\container\exceptions\NoDefaultValueException;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionParameter;

class Container implements ContainerInterface
{
    private array $entries = [];

    public function get($id)
    {
        if (!$this->has($id)) {
            $this->set($id);
        }

        $concrete = $this->entries[$id];

        return $this->resolve($concrete);
    }

    public function has($id)
    {
        return isset($this->entries[$id]);
    }

    public function set($id, $concrete = null)
    {
        if ($concrete === null) {
            $concrete = $id;
        }

        $this->entries[$id] = $concrete;
    }

    public function resolve($id)
    {
        $reflection = new ReflectionClass($id);

        if (!$reflection->isInstantiable()) {
            throw new DependencyIsNotInstantiableException("Class is not instantiable");
        }

        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            return $reflection->newInstance();
        }

        $params = $constructor->getParameters();
        $dependencies = $this->getDependencies($params, $reflection);
        return $reflection->newInstanceArgs($dependencies);
    }

    private function getDependencies($params, $reflection) {
        $dependencies = [];

        foreach ($params as $param) {
            $dependency = $param->getClass();
            if (is_null($dependency)) {
                if ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                } else {
                    throw new \Exception("No default value available");
                }
            } else {
                $dependencies[] = $this->get($dependency->name);
            }
        }
        return $dependencies;
    }


}