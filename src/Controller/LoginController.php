<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LoginController extends AbstractController
{
    /**
     * @Route("/login")
     */
    public function login()
    {
        # Note: Generally we don't hardcode urls, we generate them instead
        # symfony will figure out what the url to that will be
        #$target = "http://18.209.27.249/authorize?redirect_uri=http://localhost:8089/login/check";
        # your routes must have a name to use this. The route defined in routes.yaml file
        # when you use annotation routes they don't make you generate a name. They have one you can find
        # by looking up ./bin/console default:route - DO NOT RELY ON THIS
        # instead add it in the annotation
        # Route(path, name) see below
        # this is generated  by a service

        # "debug:auto-wiring rout""
        # you could pass in the GenerateUrl OR in controller there is a shortcut
        #$loginCheck = $this->generateUrl('app_login_check', ['max' => 10]);
        # certain things need absolute urls, that is what we need here. Emails need these too

        #$loginCheck = $this->generateUrl('app_login_check', [], UrlGeneratorInterface::ABSOLUTE_URL);
        #$target = "http://18.209.27.249/authorize?" . $loginCheck;

        $loginCheck = $this->generateUrl('app_login_check', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $target = 'http://18.209.27.249/authorize?redirect_uri=' . $loginCheck;

        return $this->redirect($target);
    }

    /**
     * @Route("/login/check", name="app_login_check")
     */
    public function loginCheck()
    {
        # we want to add an authenticator that runs before the controller
        # If we don't create a reoute then when sso redirects back here router listener would throw a 404
        # before our firewall ever had a chance to run since it has a loewr priority
        # this is a dummy route for this reason
        # if we moved this into yaml we could have a route with a path and no controller on it
        # controller would never be executed, but we need a route

        dd($this->getUser());
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('method should be intercepted by a listener');
    }
}
