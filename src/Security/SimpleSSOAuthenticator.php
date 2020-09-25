<?php

namespace App\Security;

#use App\Service\LuckyNumberGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

# SS: Template  generated using`php bin/console make:auth`

class SimpleSSOAuthenticator extends AbstractGuardAuthenticator
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    # SS - the generated methods are the steps of auth we need to implement
    # what do on auth success, failure etc.
    public function supports(Request $request)
    {

        # SS: Instead of checking the url you could check if the url has this name
        # return $request->attributes->get('_route')
        # request object is a rare instance in symfony where there are public properties
        # eg. query (a glorified array which holds request parameters from the page
        # $request->query->get('page');
        # $request->request->get (post data is known as request data
        # SS: $request->attributes - store info about the request that are specific to our app
        # - allows stashing the name of the route
        # - plain dumb holder of attributes

        # SS: Sometimes it looks for tokens in the header

        return $request->getPathInfo() === '/login/check';
        # SS: if this returns false everything else is skipped
    }

    public function getCredentials(Request $request)
    {
        return [
            'email' => $request->query->get('email'),
            'name' => $request->query->get('name'),
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = new User();
        $user->setEmail($credentials['email']);
        $user->setName($credentials['name']);
        $user->setRoles(['ROLE_USER']);

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // todo
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        $url = $this->router->generate('app_lucky_number', ['max' => 10]);

        return new RedirectResponse($url);
    }


    public function start(Request $request, AuthenticationException $authException = null)
    {
        // todo
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
