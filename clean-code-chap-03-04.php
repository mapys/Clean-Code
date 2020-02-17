<?php

use App\Cryptographer;
use App\User;
use App\Session;

class UserValidator 
{
    public function checkPassword($userName, $password) {
        $user = User::findByName($userName);
        
        if ($user != NULL) {
            $codedPhrase = $user.getPhraseEncodedByPassword();
            $phrase = Cryptographer::decrypt($codedPhrase, $password);
            
            if ($phrase === "Valid Password") {
                Session::initialize();
                return true;
            }
        }
    return false;
    }
}