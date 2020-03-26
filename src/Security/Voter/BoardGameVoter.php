<?php

namespace App\Security\Voter;

use App\Entity\BoardGame;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class BoardGameVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return $attribute === ['GAME_EDIT']
            && $subject instanceof \App\Entity\BoardGame;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        dump($subject->getAuthor());
        dump($user);
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        /** @var BoardGame $subject */
        if($subject->getAuthor() === $user){
            return true;
        }

        return false;
    }
}
