<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\PersonRepository;
use App\Entity\Person;

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

    /** 
    *@Route("/api/person", name="api_person_add",methods="POST") 
    */ 
    public function add(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator) 
    { 
        $contenu = $request->getContent(); 
        $personne = $serializer->deserialize($contenu, Person::class, 'json'); 
        $entityManager->persist($personne); $entityManager->flush(); 
        return $this->json($personne, 201, [], ['groups' => 'person:read']);
    }
}
