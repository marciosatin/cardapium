<?php

namespace Cardapium;

use Xtreamwayz\Pimple\Container;

class ServiceContainer implements ServiceContainerInterface
{

    private $container;

    /**
     * ServiceContainer constructor.
     *
     * @param $container
     */
    public function __construct()
    {
        $this->container = new Container();
    }

    public function addLazy($name, callable $callable)
    {
        $this->container[$name] = $this->container->factory($callable);
    }

    public function add($name, $service)
    {
        $this->container[$name] = $service;
    }

    public function get($name)
    {
        return $this->container->get($name);
    }

    public function has($name)
    {
        return $this->container->has($name);
    }

}
