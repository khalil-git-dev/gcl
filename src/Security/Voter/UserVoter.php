<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class UserVoter extends Voter implements VoterInterface
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST_EDIT', 'POST_VIEW']) // les actions a faire
            && $subject instanceof User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {   
         //SUPER_ADMIN can do anything they want !
        $userConnect = $token->getUser();

        // Recuperation du role de l'utilisateur a manipuler
        $roleUserSubject = strtoupper($subject->getRole()->getLibelle());
        
        // if the user is anonymous, do not grant access
        if (!$userConnect instanceof UserInterface) {
            return false;
        }
        // ... (check conditions and return true to grant permission) ...

        switch ($attribute) {
            case 'POST_EDIT':   //qui peut ajouter
                // logic to determine if the user can EDIT
                if(strtoupper($userConnect->getRoles()[0])==="ROLE_SUP_ADMIN"){
                    return true;
                }else if(strtoupper($userConnect->getRoles()[0])==="ROLE_USER" || strtoupper($userConnect->getRoles()[0])==="ROLE_PROFESSEUR"){
                    return false;
                }else if(strtoupper($userConnect->getRoles()[0])==="ROLE_PROVISEUR" && ($roleUserSubject === "PROFESSEUR" || $roleUserSubject === "USER")){
                    return true;
                }
                              
                break;
            case 'POST_VIEW':
                // logic to determine if the user can VIEW
                if($userConnect->getRoles()[0]==="ROLE_USER"){
                    return false;
                }
                // else if(strtoupper($userConnect->getRoles()[0])==="ROLE_ADMIN_PARTENAIRE" && strtoupper($subject->getRole()->getLibelle()) === "USER_PARTENAIRE")
                // {
                //     return true;
                // } 
                break;
        }
        return false;
    }
}
