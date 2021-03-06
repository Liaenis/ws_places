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
use App\Repository\PlaceRepository;
use App\Entity\Place;

class PlaceController extends AbstractController
{
    /**
     * @Route("/api/place", name="place", methods="GET")
     */
    public function index(PlaceRepository $placeRepository ,NormalizerInterface $normalizer): Response { 
        $places = $placeRepository->findAll(); 
        $normalized = $normalizer->normalize($places, null,['groups'=>'place:read']);
        $json = json_encode($normalized); 
        $reponse = new Response($json, 200, [ 'content-type' => 'application/json' ]); 
        return $reponse;
    }

    /** 
     *@Route("/api/place/{id}", name="api_place_avec_id", methods="GET") 
     */ 
    public function findById(PlaceRepository $placeRepository,$id ,NormalizerInterface $normalizer): Response { 
        $place = $placeRepository->find($id); 
        $normalized = $normalizer->normalize($place, null,['groups'=>'place:read']);
        $json = json_encode($normalized); 
        $reponse = new Response($json, 200, [ 'content-type' => 'application/json' ]); 
        return $reponse; 
    }
    /** 
* @Route("/api/place", name="api_place_add",methods="POST") 
*/ 
    public function add(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    { 
    $contenu = $request->getContent(); 
    try { $endroit = $serializer->deserialize($contenu, Place::class, 'json');
       $errors = $validator->validate($endroit); 
       if (count($errors) > 0) 
       { 
           return $this->json($errors, 400); 
       } 
       $entityManager->persist($endroit); 
       $entityManager->flush(); 
       return $this->json($endroit, 201, [], ['groups' => 'place:read']); 
    } 
    catch (NotEncodableValueException $e) 
    { 
       return $this->json(['status' => 400,'message' => $e->getMessage()]); 
    } 
    }
    public function addlike(EntityManagerInterface $paraEntityManager, 
    ValidatorInterface $validator)
    {

    }

}
