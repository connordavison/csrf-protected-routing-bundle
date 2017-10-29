<?php

use Davison\CsrfProtectedRoutingBundle\Authentication\RoutingTokenManager;
use Davison\CsrfProtectedRoutingBundle\Authentication\RequestValidator;
use Davison\CsrfProtectedRoutingBundle\Authentication\TokenRequirementChecker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RequestValidatorTest extends TestCase
{
    /**
     * @dataProvider validationProvider
     */
    public function testValidation(bool $isTokenRequired, bool $isTokenValid, bool $expected)
    {
        $requirementChecker = $this->createMock(TokenRequirementChecker::class);
        $manager = $this->createMock(RoutingTokenManager::class);
        $request = $this->createMock(Request::class);
        $validator = new RequestValidator($requirementChecker, $manager, '_csrf_token');

        $requirementChecker
            ->method('isRequiredForRequest')
            ->with($request)
            ->willReturn($isTokenRequired);

        $manager
            ->method('isTokenValid')
            ->with('my-token-value')
            ->willReturn($isTokenValid);

        $request
            ->method('get')
            ->with('_csrf_token')
            ->willReturn('my-token-value');

        $this->assertSame($expected, $validator->validate($request));
    }

    public function validationProvider()
    {
        return [
            [false, false, true],
            [false, true, true],
            [true, false, false],
            [true, true, true],
        ];
    }
}