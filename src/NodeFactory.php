<?php

namespace Shura\Node;

class NodeFactory
{
    private static $instance;

    public static function defaultFactories()
    {
        return [
            \Shura\Node\CommandBuilders\SystemNodeCommandBuilder::class,
            \Shura\Node\CommandBuilders\LocalNodeCommandBuilder::class,
        ];
    }

    public static function getFirstValidFactory($factories)
    {
        if (is_string($factories)) {
            $factories = [$factories];
        }

        if (is_array($factories)) {
            foreach ($factories as $factory) {
                $interfaces = class_implements($factory);
                if (class_exists($factory) &&
                    $interfaces &&
                    in_array(NodeCommandBuilderInterface::class, $interfaces) &&
                    method_exists($factory, 'isValid') &&
                    $factory::isValid()) {
                    return $factory;
                }
            }
        }
    }

    public static function setFactory($factories)
    {
        $factory = self::getFirstValidFactory($factories);

        if (isset($factory)) {
            return self::$instance = new $factory();
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::setFactory(self::defaultFactories());
        }

        return self::$instance;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::getInstance(), $name], $arguments);
    }
}
