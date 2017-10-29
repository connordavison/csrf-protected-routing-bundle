<?php

namespace Davison\CsrfProtectedRoutingBundle\Listener;

use Davison\CsrfProtectedRoutingBundle\Authentication\RequestValidator;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ValidateRequestListener
{
    private $validator;

    public function __construct(RequestValidator $validator)
    {
        $this->validator = $validator;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if (!$this->validator->validate($event->getRequest())) {
            throw new SuspiciousOperationException(
                'CSRF token incorrect or missing from request parameters'
            );
        }
    }
}