<?php

namespace Cardapium\Plugins;

use Cardapium\ServiceContainerInterface;
/**
 *
 * @author Marcio
 */
interface PluginInterface
{
    public function register(ServiceContainerInterface $container);
}
