<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Doodle;

class ApiController extends AbstractController
{

  #[Route('/api', name: 'app_api')]
  public function enregistrer(Request $request)
  {
    $data = json_decode($request->getContent(), true);
    // Insérer les données dans la base de données ou dans un fichier
    return new Response($request->getContent(), 200);
  }

  #[Route('/api/postCalendar/{dateHash}', name: 'app_postCalendar')]
  public function postCalendar(ManagerRegistry $doctrine, Request $request, $dateHash)
  {
    $data = json_decode($request->getContent(), true);

    $doodleRepository = $doctrine->getRepository(Doodle::class);
    $doodle = $doodleRepository->findOneBy(['dateHash' => $dateHash]);
    $userDoodles = $doodle->getUserDoodles();
    $userDoodles->toArray(); // obligatoire si on veut charger les données


    foreach ($userDoodles as $userDoodle) {
      if ($userDoodle->getUserName() === $data["user"]) {
        $userDoodle->setCalendrier(json_encode($data['weeks']));
        break;
      }
    }

    /*FORMAT de la case :
                                 [   {
                  "week": "19/03/2023",
                  "selectedCases": ["Mardi-Matin", "Mardi-Midi", "Mercredi-Midi", "Mercredi-Aprem"]
                },
                {
                  "week": "26/03/2023",
                  "selectedCases": ["Vendredi-Matin", "Vendredi-Midi", "Vendredi-Aprem"]
                }
              ] */


    // Enregistrer les modifications dans la base de données
    $entityManager = $doctrine->getManager();
    $entityManager->flush();

    // Insérer les données dans la base de données ou dans un fichier
    return new Response($request->getContent(), 200);
  }


  #[Route('/api/getAllCalendarByID/{dateHash}', name: 'app_getAllCalendarByID')]
  public function getAllCalendarByID(ManagerRegistry $doctrine, Request $request, $dateHash)
  {
    $doodleRepository = $doctrine->getRepository(Doodle::class);
    $doodle = $doodleRepository->findOneBy(['dateHash' => $dateHash]);
    $userDoodle = $doodle->getUserDoodles();
    $userDoodle->toArray(); // obligatoire si on veux charger les données
    $calendrier = '';
    $first = true;
    foreach ($userDoodle as $userD) {
      if (!$first) {
        $calendrier .= ',';
      }


      $calendrier .= '{"user": "' . $userD->getUserName() . '",';
      $calendrier .= '"color": "' . $userD->getUserColor() . '",';
      $calendrier .= '"weeks":';
      $calendrier .= $userD->getCalendrier();
      $calendrier .= '}';
      $first = false;
    }

    $data = '[' . $calendrier . ']';

    /*
FORMAT de la case :
                                 [   {
                  "week": "19/03/2023",
                  "selectedCases": ["Mardi-Matin", "Mardi-Midi", "Mercredi-Midi", "Mercredi-Aprem"]
                },
                {
                  "week": "26/03/2023",
                  "selectedCases": ["Vendredi-Matin", "Vendredi-Midi", "Vendredi-Aprem"]
                }
              ]



    FORMAT TOTAL ATTENDU PAR LE FRONT
    
    $data = '[
            {
              "user": "Julien",
              "color":"#1FF012",
              "weeks": [
                {
                  "week": "19/03/2023",
                  "selectedCases": ["Dimanche-Matin", "Samedi-Matin", "Vendredi-Matin", "Jeudi-Matin", "Mercredi-Matin", "Mardi-Matin", "Lundi-Midi", "Mardi-Midi", "Mardi-Aprem", "Mercredi-Aprem"]
                },
                {
                  "week": "26/03/2023",
                  "selectedCases": ["Mardi-Matin", "Mercredi-Matin", "Jeudi-Matin", "Vendredi-Matin", "Samedi-Matin"]
                }
              ]
            },
            {
              "user": "Charles",
              "color":"#F11012",
              "weeks": [
                {
                  "week": "19/03/2023",
                  "selectedCases": ["Mardi-Matin", "Mardi-Midi", "Mercredi-Midi", "Mercredi-Aprem"]
                },
                {
                  "week": "26/03/2023",
                  "selectedCases": ["Vendredi-Matin", "Vendredi-Midi", "Vendredi-Aprem"]
                }
              ]
            },{
              "user": "Delphine",
              "color":"#2A1012",
              "weeks": [
                {
                  "week": "19/03/2023",
                  "selectedCases": ["Mardi-Matin", "Mardi-Midi", "Mercredi-Midi", "Mercredi-Aprem"]
                },
                {
                  "week": "26/03/2023",
                  "selectedCases": ["Vendredi-Matin", "Vendredi-Midi", "Vendredi-Aprem"]
                }
              ]
            },
            {
              "user": "Pascal",
              "color":"#8A3018",
              "weeks": [
                {
                  "week": "19/03/2023",
                  "selectedCases": ["Mardi-Matin", "Mardi-Midi", "Mercredi-Midi", "Mercredi-Aprem"]
                },
                {
                  "week": "26/03/2023",
                  "selectedCases": ["Vendredi-Matin", "Vendredi-Midi", "Vendredi-Aprem"]
                }
              ]
            },
            {
              "user": "David",
              "color":"#C130C8",
              "weeks": [
                {
                  "week": "19/03/2023",
                  "selectedCases": ["Mercredi-Matin", "Mercredi-Midi", "Jeudi-Midi", "Jeudi-Aprem"]
                },
                {
                  "week": "26/03/2023",
                  "selectedCases": ["Lundi-Matin", "Lundi-Midi", "Lundi-Aprem", "Mardi-Matin", "Mardi-Aprem", "Mercredi-Matin", "Mercredi-Aprem"]
                }
              ]
            },
            {
              "user": "laure",
              "color":"#C9320D",
              "weeks": [
                {
                  "week": "19/03/2023",
                  "selectedCases": ["Mercredi-Matin", "Jeudi-Midi", "Jeudi-Aprem"]
                },
                {
                  "week": "26/03/2023",
                  "selectedCases": ["Lundi-Matin", "Mardi-Matin", "Mardi-Aprem", "Mercredi-Matin", "Mercredi-Aprem"]
                }
              ]
            }
          ]';
*/
    return  new Response($data, 200);
  }
}
