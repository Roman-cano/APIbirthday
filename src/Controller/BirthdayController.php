<?php

namespace App\Controller;

use App\Entity\Birthday;
use App\Repository\UserRepository;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Repository\BirthdayRepository;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/birthday")
 */
class BirthdayController extends AbstractController
{
    /**
     * @Route("/", name="app_birthday_index", methods={"GET"})
     */
    public function index(BirthdayRepository $birthdayRepository): JSONResponse
    {
        $serializer = SerializerBuilder::create()->build();
        $birthdays = $birthdayRepository->findAll();

        $jsonContent = $serializer->serialize($birthdays, 'json');
        return new JsonResponse($jsonContent, 200, [], true);
    }

    /**
     * @Route("/", name="app_birthday_new", methods={"POST"})
     */
    public function new(Request $request, BirthdayRepository $birthdayRepository, UserRepository $userRepository): JSONResponse
    {

        $data = json_decode($request->getContent(), true);


        $nom = $data['nom'];
        $prenom = $data['prenom'];
        $anniversaire = $data['anniversaire'];

        $dateAnniv = \DateTime::createFromFormat('Y-m-d', $anniversaire);
        $user = $userRepository->find(1);

        $birthday = new Birthday();
        $birthday->setNom($nom);
        $birthday->setPrenom($prenom);
        $birthday->setAnniversaire($dateAnniv);
        $birthday->setAuser($user);

        $birthdayRepository->add($birthday, true);

        $serializer = SerializerBuilder::create()->build();
        $context = SerializationContext::create()->setGroups(['birthday_detail']);
        $jsonContent = $serializer->serialize($birthday, 'json', $context);

        return new JsonResponse($jsonContent, 200, [], true);
    }

    /**
     * @Route("/{id}", name="app_birthday_show", methods={"GET"})
     */
    public function show(Birthday $birthday): Response
    {
        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($birthday, 'json');
        return new JsonResponse($jsonContent, 200, [], true);

    }

    /**
     * @Route("/{id}", name="app_birthday_edit", methods={"GET", "POST","PUT"})
     */
    public function edit(Request $request, Birthday $birthday, BirthdayRepository $birthdayRepository): Response
    {
        $serializer = SerializerBuilder::create()->build();
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'];
        $prenom = $data['prenom'];
        $anniversaire = $data['anniversaire'];
        $dateAnniv = \DateTime::createFromFormat('Y-m-d', $anniversaire);

        $birthday->setAnniversaire($dateAnniv);
        $birthday->setNom($nom);
        $birthday->setPrenom($prenom);
        $birthdayRepository->add($birthday, true);
        $jsonContent = $serializer->serialize($birthday, 'json');
        return new JsonResponse($jsonContent, 200, [], true);
    }

    /**
     * @Route("/{id}", name="app_birthday_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Birthday $birthday, BirthdayRepository $birthdayRepository): Response
    {
            $birthdayRepository->remove($birthday, true);



        return $this->redirectToRoute('app_birthday_index', [], Response::HTTP_SEE_OTHER);
    }
}
