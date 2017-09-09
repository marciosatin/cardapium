<?php

namespace Cardapium;

/**
 *
 * @author Marcio
 */
interface ServiceContainerInterface
{

    public function add($name, $service);

    public function addLazy($name, callable $callable);

    public function get($name);

    public function has($name);
}
