<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/all", name="formation_index", methods={"GET"})
     */
    public function index (FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/", name="formation_list", methods={"GET"})
     */
    public function formations (FormationRepository $formationRepository): Response
    {
        return $this->render('formation/listFormation.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/formateur", name="formationFormateur_index", methods={"GET"})
     */
    public function index_formateur (FormationRepository $formationRepository): Response
    {
        return $this->render('formation/listFormation_Formateur.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/formation/candidat", name="formationCandidat_index", methods={"GET"})
     */
    public function index_candidat(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/listFormation_Candidat.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/formation/admin", name="formationAdmin_index", methods={"GET"})
     */
    public function index_admin(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/listFormation_Admin.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/new", name="formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('formationFormateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/show", name="formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("formateur/{id}", name="formationFormateur_show", methods={"GET"})
     */
    public function show_formateur(Formation $formation): Response
    {
        return $this->render('formation/show_Formateur.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formationFormateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("formateur/{id}", name="formation_delete", methods={"POST"})
     */
    public function delete(Request $request, Formation $formation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formationFormateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
