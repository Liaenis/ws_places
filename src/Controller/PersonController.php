<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use App\Repository\PersonRepository;

class PersonController extends AbstractController
{
/**
 *@Route("/api/person", name="api_person", methods="GET") 
 */ 
    public function index(PersonRepository $personRepository,NormalizerInterface $normalizer): Response { 
    $personnes = $personRepository->findAll(); 
    $normalized = $normalizer->normalize($personnes,null,['groups'=>'person:read']);
        // json_encode encore transforme la classe en json
    $json = json_encode($normalized); 
    $reponse = new Response($json, 200, [ 'content-type' => 'application/json' ]); 
    return $reponse; 
    }
/**
*@Route("/api/person/{id}", name="api_person_avec_id", methods="GET") 
*/ 
    public function findById(PersonRepository $personRepository,NormalizerInterface $normalizer,$id): Response { 
        $person = $personRepository->find($id); 
        $normalized = $normalizer->normalize($person,null,['groups'=>'person:read']);
        $json = json_encode($normalized); 
        $reponse = new Response($json, 200, [ 'content-type' => 'application/json' ]); 
        return $reponse; 
    }
}
