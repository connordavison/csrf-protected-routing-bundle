<?php

namespace Davison\CsrfProtectedRoutingBundle\Routing;


use Davison\CsrfProtectedRoutingBundle\Authentication\RoutingTokenManager;
use Davison\CsrfProtectedRoutingBundle\Authentication\TokenRequirementChecker;

class TokenParameterResolver
{
    private $requirementChecker;
    private $tokenManager;
    private $parameterName;

    public function __construct(
        TokenRequirementChecker $requirementChecker,
        RoutingTokenManager $tokenManager,
        string $parameterName
    ) {
        $this->requirementChecker = $requirementChecker;
        $this->tokenManager = $tokenManager;
        $this->parameterName = $parameterName;
    }

    public function resolve(string $route): array
    {
        if ($this->requirementChecker->isRequiredForRoute($route)) {
            return [$this->parameterName => $this->tokenManager->getToken()];
        }

        return [];
    }
}