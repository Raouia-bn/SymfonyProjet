<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\InscriFormation;
use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/session")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/all", name="session_index", methods={"GET"})
     */
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }
    /**
     * @Route("/formateur", name="sessionFormateur_index", methods={"GET"})
     */
    public function index_Formateur(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/listSession_Formateur.html.twig', [
            'listSession' => $sessionRepository->findAll(),
        ]);
    }
    /**
     * @Route("/formation/{id}", name="session_formation_list", methods={"GET"})
     */
    public function sessions_formation(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $formation = $em->getRepository(Formation::class)->find($id);
        $session = $formation->getSessions();

        return $this->render('session/listSession.html.twig', [
            "listSession" => $session
        ]);
    }
    /**
     * @Route("/candidat/{id}", name="sessionCand_list", methods={"GET"})
     */
    public function sessions(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $formation = $em->getRepository(Formation::class)->find($id);
        $session = $formation->getSessions();
        $user=$this->getUser()->getId();
        $currentsession=$this->getDoctrine()->getRepository(Session::class)->findOneBy(['formation'=>$formation->getId()]);
        //dump($session);die();
        $userSession=$this->getDoctrine()->getRepository(InscriFormation::class)->findOneBy(['candidate'=>$user,'session'=>$currentsession->getId()]);
        if(empty($userSession))
        {
            $enabled=true;
        }
        else
            $enabled=false;
        return $this->render('session/listSession_Candidat.html.twig', [
            "Sessions" => $session, "enabled"=>$enabled
        ]);
    }
    /**
     * @Route("/formateur/{id}", name="session_list_Formateur", methods={"GET"})
     */
    public function sessions_formateur(ManagerRegistry $doctrine, int $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $formation = $em->getRepository(Formation::class)->find($id);
        $session = $formation->getSessions();

        return $this->render('session/listSession_Formateur.html.twig', [
            "listSession" => $session,
            "formation"=> $id
        ]);
    }
    /**
     * @Route("/new", name="session_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('session_list_Formateur', ['id' => $session->getFormation()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session/new.html.twig', [
            'session' => $session,
            'form' => $form
        ]);
    }

    /**
     * @Route("formation/{id}/show", name="session_show", methods={"GET"})
     */
    public function show(Session $session): Response
    {
        return $this->render('session/show.html.twig', [
            'session' => $session,
        ]);
    }
    /**
     * @Route("formateur/{id}", name="formateurSession_show", methods={"GET"})
     */
    public function show_formateur_session(Session $session): Response
    {
        return $this->render('session/show_Formateur.html.twig', [
            'session' => $session,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="session_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Session $session): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('session_list_Formateur', ['id' => $session->getFormation()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session/edit.html.twig', [
            'session' => $session,
            'form' => $form,
        ]);
    }

    /**
     * @Route("formateur/{id}", name="session_delete", methods={"POST"})
     */
    public function delete(Request $request, Session $session): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sessionFormateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
