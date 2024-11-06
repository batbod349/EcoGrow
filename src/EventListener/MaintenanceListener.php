<?php

namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class MaintenanceListener
{
    private $security;
    private $router;
    private $maintenanceMode;

    public function __construct(Security $security, RouterInterface $router, string $maintenanceMode)
    {
        $this->security = $security;
        $this->router = $router;
        $this->maintenanceMode = $maintenanceMode;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->maintenanceMode === 'true') {
            $request = $event->getRequest();
            $currentRoute = $request->attributes->get('_route');

            if ($currentRoute !== 'app_maintenance') {
                $user = $this->security->getUser();
                if (!$user || !$this->security->isGranted('ROLE_ADMIN')) {
                    $response = new RedirectResponse($this->router->generate('app_maintenance'));
                    $event->setResponse($response);
                }
            }
        }
    }
}