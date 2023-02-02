<?php

namespace App\Controller;

use App\Entity\Medecin;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ServiceController extends AbstractController
{
    /*private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }*/

    #[Route('/service', name: 'app_service')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();
        $unMedecin = new Medecin();
        $unMedecin->setNom("Daddy");
        $unMedecin->setPrenom("Blue");
        $entityManager->persist($unMedecin);
        $entityManager->flush();

         $unMedecin = $doctrine->getRepository(Medecin::class)->find(1);
    

        if (!$unMedecin) {
            throw $this->createNotFoundException(
                'No product found for id 1'
            );
        }


        return $this->render('service/index.html.twig', [
            'controller_name' => $unMedecin->getNom(),
        ]);
    }
}
