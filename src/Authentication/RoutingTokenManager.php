<?php

namespace Davison\CsrfProtectedRoutingBundle\Authentication;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class RoutingTokenManager
{
    private $tokenManager;
    private $tokenId;

    public function __construct(
        CsrfTokenManagerInterface $tokenManager,
        string $tokenId
    ) {
        $this->tokenManager = $tokenManager;
        $this->tokenId = $tokenId;
    }

    public function getToken(): string
    {
        return $this->tokenManager->getToken($this->tokenId)->getValue();
    }

    public function isTokenValid($tokenValue): bool
    {
        return $this->tokenManager->isTokenValid(
            new CsrfToken($this->tokenId, $tokenValue)
        );
    }
}