<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    /**
     * @Route("/")
     */
class MembreController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {

        $membres = $this->getDoctrine()
        ->getRepository(Membre::class)
        ->getAll();

        $new = new Membre();

        $form = $this->createForm(MembreType::class, $new);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($new);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('membre/index.html.twig', [
                'membres' => $membres,
                'form' => $form->createView()
            ]);

    }


}
