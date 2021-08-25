<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use App\Repository\PlaceRepository;

class PlaceController extends AbstractController
{
    /**
     * @Route("/api/place", name="place", methods="GET")
     */
    public function index(PlaceRepository $placeRepository ,NormalizerInterface $normalizer): Response { 
        $places = $placeRepository->findAll(); 
        $normalized = $normalizer->normalize($places); 
        $json = json_encode($normalized); 
        $reponse = new Response($json, 200, [ 'content-type' => 'application/json' ]); 
        return $reponse;
    }

    /** 
     *@Route("/api/place/{id}", name="api_place_avec_id", methods="GET") 
     */ 
    public function findById(PlaceRepository $placeRepository,$id ,NormalizerInterface $normalizer): Response { 
        $place = $placeRepository->find($id); 
        $normalized = $normalizer->normalize($person,null,['groups'=>'place:read']);
        $json = json_encode($normalized); 
        $reponse = new Response($json, 200, [ 'content-type' => 'application/json' ]); 
        return $reponse; 
    }
}
