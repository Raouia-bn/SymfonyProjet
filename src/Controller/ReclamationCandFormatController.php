<?php

namespace App\Controller;

use App\Entity\InscriFormation;
use App\Entity\ReclamationCandFormat;
use App\Form\ReclamationCandFormatType;
use App\Repository\ReclamationCandFormatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reclamation/cand/format")
 */
class ReclamationCandFormatController extends AbstractController
{
    /**
     * @Route("/", name="reclamation_cand_format_index", methods={"GET"})
     */
    public function index(ReclamationCandFormatRepository $reclamationCandFormatRepository): Response
    {
        return $this->render('reclamation_cand_format/index.html.twig', [
            'reclamation_cand_formats' => $reclamationCandFormatRepository->findAll(),
        ]);
    }
    /**
     * @Route("/listReclamationCand", name="reclamation_cand_format_list", methods={"GET"})
     */
    public function listreclamation_cand(Request $request): Response
    {
        $idUser=$this->getUser()->getId();
        $listRecl=$this->getDoctrine()->getRepository(ReclamationCandFormat::class)->findBy(['candidat'=>$idUser]);
        return $this->render('reclamation_cand_format/index_cand.html.twig', [
            'reclamation_cand_formats' => $listRecl,
        ]);
    }

    /**
     * @Route("/new", name="reclamation_cand_format_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reclamationCandFormat = new ReclamationCandFormat();
        $form = $this->createForm(ReclamationCandFormatType::class, $reclamationCandFormat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamationCandFormat);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation_cand_format_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation_cand_format/new.html.twig', [
            'reclamation_cand_format' => $reclamationCandFormat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="reclamation_cand_format_show", methods={"GET"})
     */
    public function show(ReclamationCandFormat $reclamationCandFormat): Response
    {
        return $this->render('reclamation_cand_format/show.html.twig', [
            'reclamation_cand_format' => $reclamationCandFormat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reclamation_cand_format_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReclamationCandFormat $reclamationCandFormat): Response
    {
        $form = $this->createForm(ReclamationCandFormatType::class, $reclamationCandFormat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_cand_format_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation_cand_format/edit.html.twig', [
            'reclamation_cand_format' => $reclamationCandFormat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="reclamation_cand_format_delete", methods={"POST"})
     */
    public function delete(Request $request, ReclamationCandFormat $reclamationCandFormat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamationCandFormat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reclamationCandFormat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reclamation_cand_format_index', [], Response::HTTP_SEE_OTHER);
    }
}
