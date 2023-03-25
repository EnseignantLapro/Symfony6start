<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    
    #[Route('/api', name: 'app_api')]
    public function enregistrer(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        // Insérer les données dans la base de données ou dans un fichier
        return new Response($request->getContent(), 200);
    }

    #[Route('/api/postCalendar', name: 'app_postCalendar')]
    public function postCalendar(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        // Insérer les données dans la base de données ou dans un fichier
        return new Response($request->getContent(), 200);
    }
    #[Route('/api/getAllCalendarByID', name: 'app_getAllCalendarByID')]
    public function getAllCalendarByID(Request $request)
    {
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
         
          return  new Response($data, 200);
    }
}


