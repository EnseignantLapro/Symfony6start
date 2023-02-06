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

    #[Route('/service/delete/{id}', name: 'app_service_delete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $medecin = $doctrine->getRepository(Medecin::class)->find($id);
        $entityManager->remove($medecin);
        $entityManager->flush();

        return $this->redirectToRoute('app_service');
    }

    #[Route('/service/edit/{id}', name: 'app_service_edit')]
    public function edit(Medecin $medecin, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_service');
    }
}
