<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Alert;
use App\Form\ALertType;


class AppController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Alert::class);
        $alerts = $repository->findBy([], ['date' => 'DESC']);
        return $this->render('app/home.html.twig', [
            'alerts' => $alerts
        ]);
    }
    #[Route('/ajouter-numero', name: 'add_phone')]
    public function addPhone(Request $request): Response
    {
        $alert = new Alert();
        $form = $this->createForm(ALertType::class, $alert);

        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($alert);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('app/ajouter-numero.html.twig', [
            'alert' => $alert,
            'form' => $form->createView()
        ]);
    }
    #[Route('/cgu', name: 'cgu')]
    public function cgu(): Response
    {
        return $this->render('app/cgu.html.twig');
    }
}
