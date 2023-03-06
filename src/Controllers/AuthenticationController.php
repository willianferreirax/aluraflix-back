<?php

namespace App\Controllers;

use App\Http\Response\Response;
use App\Services\TokenIssuer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Response\Response as JsonResponse;

class AuthenticationController extends AbstractController{

    public function __construct(
        private EntityManagerInterface $manager,
        private TokenIssuer $issuer
    ){}

    public function authenticate(Request $request): Response {

        $requestData = json_decode($request->getContent(), true);

        $login = $requestData['login'];
        $pass = $requestData['password'];

        if(!$login || !$pass){
            throw new \DomainException('Invalid credentials', Response::HTTP_UNAUTHORIZED);
        }

        $user = $this->manager->getRepository(\App\Models\User::class)->findOneBy([
            'login' => $login,
        ]);

        if(!$user){
            throw new \DomainException('Login and/or password incorrect(s)', Response::HTTP_UNAUTHORIZED);
        }

        if(!\App\Services\Authenticator::authenticate($user, $pass)){
            throw new \DomainException('Login and/or password incorrect(s)', Response::HTTP_UNAUTHORIZED);
        }

        $token = $this->issuer->issueToken($user);

        return new JsonResponse([
            'token' => $token->toString()
        ]);

    }

}