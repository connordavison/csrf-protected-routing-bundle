<?php

namespace Davison\CsrfProtectedRoutingBundle\Authentication;

use Symfony\Component\HttpFoundation\Request;

class RequestValidator
{
    private $requirementChecker;
    private $manager;
    private $paramName;

    public function __construct(
        TokenRequirementChecker $requirementChecker,
        RoutingTokenManager $manager,
        string $tokenParamName
    ) {
        $this->requirementChecker = $requirementChecker;
        $this->manager = $manager;
        $this->paramName = $tokenParamName;
    }

    public function validate(Request $request): bool
    {
        if ($this->requirementChecker->isRequiredForRequest($request)) {
            return $this->manager->isTokenValid($request->get($this->paramName));
        }

        return true;
    }
}