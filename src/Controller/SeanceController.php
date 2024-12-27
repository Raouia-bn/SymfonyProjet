<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Seance;
use App\Entity\Session;
use App\Form\SeanceType;
use App\Repository\SeanceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/seance")
 */
class SeanceController extends AbstractController
{

    /**
     * @Route("/all", name="seance_index", methods={"GET"})
     */
    public function index(SeanceRepository $seanceRepository): Response
    {
        return $this->render('seance/index.html.twig', [
            'seances' => $seanceRepository->findAll(),
        ]);
    }
    /**
     * @Route("/formateur", name="seanceFormateur_index", methods={"GET"})
     */
    public function index_Formateur(SeanceRepository $seanceRepository): Response
    {
        return $this->render('seance/listSeance_Formateur.html.twig', [
            'listSeance' => $seanceRepository->findAll(),
        ]);
    }
    /**
     * @Route("/seances/{id}", name="seance_list", methods={"GET"})
     */
    public function seances(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $session = $em->getRepository(Session::class)->find($id);
        $seance = $session->getSeances();

        return $this->render('seance/listSeance.html.twig', [
            "listSeance" => $seance
        ]);
    }

    /**
     * @Route("formateur/seance/{id}", name="seanceFormateur_list", methods={"GET"})
     */
    public function seances_formateur(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $session = $em->getRepository(Session::class)->find($id);
        $seance = $session->getSeances();

        return $this->render('seance/listSeance_Formateur.html.twig', [
            "listSeance" => $seance,
            "session" => $session
        ]);
    }

    /**
     * @Route("/new", name="seance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $seance = new Seance();
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($seance);
            $entityManager->flush();

            return $this->redirectToRoute('seanceFormateur_list', ['id'=>$seance->getSession()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance/new.html.twig', [
            'seance' => $seance,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="seance_show", methods={"GET"})
     */
    public function show(Seance $seance): Response
    {
        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
        ]);
    }
    /**
     * @Route("formateurshow/{id}", name="seance_formateur_show", methods={"GET"})
     */
    public function show_formateur(Seance $seance): Response
    {
        return $this->render('seance/show_Formateur.html.twig', [
            'seance' => $seance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="seance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Seance $seance): Response
    {
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('seanceFormateur_list', ['id' => $seance->getSession()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('seance/edit.html.twig', [
            'seance' => $seance,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}/delete", name="seance_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, Seance $seance): Response
    {
        $session = $seance->getSession();
        $listseance=$session->getSeances();
        if ($this->isCsrfTokenValid('delete'.$seance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($seance);
            $entityManager->flush();
        }
        //dump($seance);die();
        return $this->render('seance/listSeance_Formateur.html.twig', [
            'listSeance' => $listseance,
            'session'=>$session]);
    }

}
