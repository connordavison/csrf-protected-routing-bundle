<?php

namespace Davison\CsrfProtectedRoutingBundle\Routing;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

class CsrfProtectedUrlGenerator implements UrlGeneratorInterface
{
    private $urlGenerator;
    private $parameterResolver;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        TokenParameterResolver $parameterResolver
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->parameterResolver = $parameterResolver;
    }

    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        $parameters = array_merge(
            $parameters,
            $this->parameterResolver->resolve($name)
        );

        return $this->urlGenerator->generate($name, $parameters, $referenceType);
    }

    public function setContext(RequestContext $context)
    {
        $this->urlGenerator->setContext($context);
    }

    public function getContext()
    {
        return $this->urlGenerator->getContext();
    }
}