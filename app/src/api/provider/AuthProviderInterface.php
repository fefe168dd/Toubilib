<?php

namespace toubilib\api\Provider;

interface AuthProviderInterface
{
   public function register(CredentialDTO $credential, int $role ): void;
   public function signin(CredentialDTO $credential): AuthDTO;
   public function refresh(Token $refreshToken): AuthDTO;
   public function getSignedinUser(Token $accessToken): AuthDTO;

}
