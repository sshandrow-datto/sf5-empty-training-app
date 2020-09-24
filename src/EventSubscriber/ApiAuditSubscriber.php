<?php


namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ApiAuditSubscriber extends EventSubscriberInterface
{
    public function onKernelRequest()
    {
        dd('it works!');
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest'
        ];
    }

}