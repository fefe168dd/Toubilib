<?php

namespace toubilib\application_core\domain\entities\auth;

use toubilib\application_core\domain\exceptions\AuthenticationException;


interface AuthServiceInterface
{
   
    public function authenticate(string $email, string $password): UserProfile;

   
    public function userExists(string $email): bool;
}