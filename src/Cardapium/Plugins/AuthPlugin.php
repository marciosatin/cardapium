<?php

declare(strict_types = 1);

namespace Cardapium\Plugins;

use Cardapium\Auth\Auth;
use Cardapium\Auth\JasnyAuth;
use Cardapium\ServiceContainerInterface;
use Interop\Container\ContainerInterface;

class AuthPlugin implements PluginInterface
{

    public function register(ServiceContainerInterface $container)
    {
        $container->addLazy('jasny.auth', function (ContainerInterface $container){
            return new JasnyAuth($container->get('user.repository'));
        });
        $container->addLazy('auth', function (ContainerInterface $container) {
            return new Auth($container->get('jasny.auth'));
        });
    }
}
