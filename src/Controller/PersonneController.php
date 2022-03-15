<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/personne", name="app_personne")
     */
    public function index(Request $request): Response
    {
        $nouvellePersonne = new Personne();
        $form = $this->createForm(PersonneType::class, $nouvellePersonne);
        $form->handleRequest($request);
        // $dateDeNaissance = $nouvellePersonne->getDateDeNaissance();
        // $aujourdhui = date("Y-m-d");
        // $age = date_diff(date_create($dateDeNaissance), date_create($aujourdhui));
        // if($age >= 150){
        //     return false;
        // }
        if($form->isSubmitted() && $form->isValid()) {


            $manager = $this->getDoctrine()->getManager();
            $manager->persist($nouvellePersonne);
            $manager->flush();

            return $this->redirectToRoute('_list', ['id' => $nouvellePersonne->getId()]);
        }

        return $this->render('personne/add.html.twig', [
            "personForm" => $form->createView()
        ]);
    }

    /**
     * @Route("/list", name="_list")
     */
    public function PersonneListe(PersonneRepository $personne): Response
    {
        return $this->render('personne/personneListe.html.twig', [
            'personne' => $personne->findAll(),
        ]);
    }

}
