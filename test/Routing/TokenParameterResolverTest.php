<?php

use Davison\CsrfProtectedRoutingBundle\Authentication\RoutingTokenManager;
use Davison\CsrfProtectedRoutingBundle\Authentication\TokenRequirementChecker;
use Davison\CsrfProtectedRoutingBundle\Routing\TokenParameterResolver;
use PHPUnit\Framework\TestCase;

class TokenParameterResolverTest extends TestCase
{
    /**
     * @dataProvider resolveProvider
     */
    public function testResolve($isTokenCheckRequired, $expectedParameters)
    {
        $requirementChecker = $this->createMock(TokenRequirementChecker::class);
        $tokenManager = $this->createMock(RoutingTokenManager::class);

        $requirementChecker
            ->method('isRequiredForRoute')
            ->with('my_route')
            ->willReturn($isTokenCheckRequired);

        $tokenManager->method('getToken')->willReturn('123abc');

        $resolver = new TokenParameterResolver(
            $requirementChecker,
            $tokenManager,
            '_csrf_token'
        );

        $this->assertSame(
            $expectedParameters,
            $resolver->resolve('my_route')
        );
    }

    public function resolveProvider()
    {
        return [
            [true, ['_csrf_token' => '123abc']],
            [false, []],
        ];
    }
}