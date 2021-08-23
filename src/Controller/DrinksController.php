<?php

namespace App\Controller;

use App\Entity\Drinks;
use App\Repository\DrinksRepository;
use Faker\Factory;
use PharIo\Manifest\Url;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DrinksController extends AbstractController
{
    #[Route('/drinks', name: 'drinks')]
    public function index(DrinksRepository $drinks): Response
    {
        $list = $drinks->findAll();

        return $this->render('drinks/index.html.twig', ["list"=>$list]);
    }

    #[Route('/adddrink', name: 'adddrink')]
    public function add(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $faker = Factory::create();
        $newDrink = new Drinks();
        $newDrink
            ->setName($faker->domainName())
            ->setDescription($faker->domainWord());
        $entityManager->persist($newDrink);
        $entityManager->flush();

        return new RedirectResponse($this->generateUrl("drinks"));
    }

}
