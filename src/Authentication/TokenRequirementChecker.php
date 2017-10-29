<?php

namespace Davison\CsrfProtectedRoutingBundle\Authentication;

use Symfony\Component\HttpFoundation\Request;

use function in_array;

class TokenRequirementChecker
{
    private $tokenRequiredRoutes;

    public function __construct(array $tokenRequiredRoutes)
    {
        $this->tokenRequiredRoutes = $tokenRequiredRoutes;
    }

    public function isRequiredForRequest(Request $request): bool
    {
        return $this->isRequiredForRoute($request->get('_route'));
    }

    public function isRequiredForRoute(string $route): bool
    {
        return in_array($route, $this->tokenRequiredRoutes);
    }
}