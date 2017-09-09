<?php

namespace Cardapium\Auth;

class Auth implements AuthInterface
{

    /**
     * @var JasnyAuth
     */
    private $jasnyAuth;

    public function __construct(JasnyAuth $jasnyAuth)
    {
        $this->jasnyAuth = $jasnyAuth;
        $this->sessionStart();
    }

    public function login(array $credentials): bool
    {
        return $this->jasnyAuth->login($credentials['email'], $credentials['password']) !== null;
    }

    public function check(): bool
    {
        return $this->jasnyAuth->user() !== null;
    }

    public function logout(): void
    {
        $this->jasnyAuth->logout();
    }

    public function hashPassword(string $password): string
    {
        return $this->jasnyAuth->hashPassword($password);
    }

    protected function sessionStart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function user()
    {
        return $this->jasnyAuth->user();
    }

}
