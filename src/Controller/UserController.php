<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="app_user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/", name="app_user")
     */

    public function new(Request $request, UserRepository $UserRepository, UserRepository $userRepository): JSONResponse
    {

        $data = json_decode($request->getContent(), true);


        $email = $data['email'];
        $passWord = $data['password'];
        $nom = $data['nom'];
        $prenom = $data['prenom'];
        $roles = $data['roles'] ?? ['ROLE_USER'];
        $hashedPassword = password_hash($passWord, PASSWORD_BCRYPT);




        $user = new User();
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setRoles($roles);
        $userRepository->add($user, true);


        $serializer = SerializerBuilder::create()->build();
        $context = SerializationContext::create()->setGroups(['birthday_detail']);
        $jsonContent = $serializer->serialize($user, 'json', $context);

        return new JsonResponse($jsonContent, 200, [], true);
    }

}
