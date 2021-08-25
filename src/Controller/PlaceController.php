<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends AbstractController
{
    /**
     * @Route("/place", name="place")
     */
    public function index(PlaceRepository $paraPlaceReposi): Response
    {
        $places = $paraPlaceReposi->findAll(); 
        $json = json_encode($places); $reponse = new Response($json, 200, [ 'content-type' => 'application/json' ]); 
        return $reponse;
    }
}
