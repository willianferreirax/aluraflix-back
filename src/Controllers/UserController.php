<?php

namespace App\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Response\Response as JsonResponse;
use App\Http\Response\Response;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse as HttpFoundationJsonResponse;

class UserController extends AbstractController{

    public function __construct(
        private EntityManagerInterface $manager
    ){}

    public function store(Request $request): HttpFoundationJsonResponse{

        $requestData = json_decode($request->getContent(), true);

        if(!$requestData){
            throw new \DomainException('Invalid request', Response::HTTP_BAD_REQUEST);
        }

        $userExists = $this->manager->getRepository(User::class)->findOneBy(['login' => $requestData['login']]);

        if($userExists){
            throw new \DomainException('User already exists', Response::HTTP_BAD_REQUEST);
        }

        $user = new User();

        $user->setName($requestData['name'] ?? '');
        $user->setLogin($requestData['login'] ?? '');
        $user->setPass($requestData['pass'] ?? '');

        $this->manager->persist($user);
        $this->manager->flush();

        return new HttpFoundationJsonResponse([
            'id' => $user->getId(),
            'name' => $user->getName()
        ]);

    }

}