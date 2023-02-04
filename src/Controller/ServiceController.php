<?php

namespace App\Controller;

use App\Entity\Medecin;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\MedecinType;
use Symfony\Component\HttpFoundation\Request;

class ServiceController extends AbstractController
{

    #[Route('/service', name: 'app_service')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {

        $entityManager = $doctrine->getManager();
        $unMedecin = new Medecin();
        
        $form = $this->createForm(MedecinType::class, $unMedecin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($unMedecin);
            $entityManager->flush();
        }

        $medecins = $doctrine->getRepository(Medecin::class)->findBy([], ['id' => 'DESC']);

        return $this->render('service/index.html.twig', [
            'controller_name' => $unMedecin->getNom(),
            'medecins' => $medecins,
            'form' => $form->createView()
        ]);
    }
}
