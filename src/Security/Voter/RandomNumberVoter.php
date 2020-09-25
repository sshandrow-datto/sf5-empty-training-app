<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RandomNumberVoter extends Voter
{
    # SS: Required method to be filled in and updated manually
    # ensure the attribute is that view thing
    protected function supports($attribute, $subject)
    {
        # SS: subject is the second parameter passed in
        # if we return false then we abstain from voting
        # true means we vote
        return $attribute === 'VIEW' && is_numeric($subject);

        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        //return in_array($attribute, ['POST_EDIT', 'POST_VIEW'])
        //    && $subject instanceof \App\Entity\RandomNumber;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof User) { // SS: ensures the user is an instance of user class
        //SS: if (!$user instanceof UserInterface) { # ensure not anonymouse
            return false;
        }

        return $subject < 20;

        // default generated stuff
        /*switch ($attribute) {
            case 'POST_EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case 'POST_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;*/
    }
}
