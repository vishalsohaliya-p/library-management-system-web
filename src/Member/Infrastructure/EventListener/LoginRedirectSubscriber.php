<?php

namespace App\Member\Infrastructure\EventListener;

use App\Member\Infrastructure\Security\JwtStorage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;

class LoginRedirectSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private JwtStorage $jwtStorage,
        private RouterInterface $router
    ) {}

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Skip sub-requests and console
        if (!$event->isMainRequest()) {
            return;
        }

        $route = $request->attributes->get('_route');

        // Routes that don’t need login
        $publicRoutes = ['app_login', 'logout'];

        if (in_array($route, $publicRoutes, true)) {
            return;
        }

        // If no token, redirect to login
        if ($this->jwtStorage->isTokenExpired()) {
            $loginUrl = $this->router->generate('app_login');
            $event->setResponse(new RedirectResponse($loginUrl));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

}
