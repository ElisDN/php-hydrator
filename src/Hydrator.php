<?php
/**
 * This file is part of the elisdn/php-hydrator library
 *
 * @copyright Copyright (c) Dmitry Eliseev <mail@elisdn.ru>
 * @license https://github.com/ElisDN/php-hydrator/blob/master/LICENSE.md
 * @link https://github.com/ElisDN/php-hydrator
 */

namespace ElisDN\Hydrator;

class Hydrator
{
    private $reflectionClassMap;

    /**
     * @param string|object $target
     * @param array $data
     * @return object
     * @throws \ReflectionException
     */
    public function hydrate($target, array $data)
    {
        $reflection = $this->getReflectionClass($target);
        $object = is_object($target) ? $target : $reflection->newInstanceWithoutConstructor();

        foreach ($data as $name => $value) {
            $property = $reflection->getProperty($name);
            if ($property->isPrivate() || $property->isProtected()) {
                $property->setAccessible(true);
            }
            $property->setValue($object, $value);
        }

        return $object;
    }

    /**
     * @param object $object
     * @param array $fields
     * @return array
     * @throws \ReflectionException
     */
    public function extract($object, array $fields)
    {
        $reflection = $this->getReflectionClass(get_class($object));
        $result = [];

        foreach ($fields as $name) {
            $property = $reflection->getProperty($name);
            if ($property->isPrivate() || $property->isProtected()) {
                $property->setAccessible(true);
            }
            $result[$property->getName()] = $property->getValue($object);
        }

        return $result;
    }

    /**
     * @param string|object $target
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    private function getReflectionClass($target)
    {
        $className = is_object($target) ? get_class($target) : $target;
        if (!isset($this->reflectionClassMap[$className])) {
            $this->reflectionClassMap[$className] = new \ReflectionClass($className);
        }
        return $this->reflectionClassMap[$className];
    }
}