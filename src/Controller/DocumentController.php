<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Formation;
use App\Form\Document1Type;
use App\Repository\DocumentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/document")
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/", name="document_index", methods={"GET"})
     */
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="document_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $document = new Document();
        $form = $this->createForm(Document1Type::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($document);
            $entityManager->flush();

            return $this->redirectToRoute('document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document/new.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="document_show", methods={"GET"})
     */
    public function show(Document $document): Response
    {
        return $this->render('document/show.html.twig', [
            'document' => $document,
        ]);

    }
    /**
     * @Route("/documents/{id}", name="documents_show", methods={"GET"})
     */
    public function documents(ManagerRegistry $doctrine, int $id, Formation $formation): Response
    {
        $em = $this->getDoctrine()->getManager();
        /*$repository= $doctrine->getRepository(Document::class);
        $this->setparameter ('id',$id);
        $document = $repository->findByFormationId($id);
            ['id' => 'ASC']
        );*/
        $formation=$em->getRepository(Formation::class)->find($id);
        $document=$formation->getDocuments();
        //$document = $em->getRepository(Document::class)->findBy(['formation_id',$id]);
        //$this->setParameter('formation_id',$id);
        return $this->render('document/listDocument.html.twig', [
            "listDocument" => $document,
            "formation" => $formation
        ]);
        /*$query= $em->createQuery('SELECT d FROM App\Entity\Document d INNER JOIN App\Entity\Formation f
        WITH d.formation_id=f.id WHERE formation_id='.$id);
        $Document=$query->getResult();
        return $this->render('/document/listDocument.html.twig',
        array(
            'listDocument'=>$Document
        ));*/
    }
    /**
     * @Route("/{id}/edit", name="document_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Document $document): Response
    {
        $form = $this->createForm(Document1Type::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document/edit.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="document_delete", methods={"POST"})
     */
    public function delete(Request $request, Document $document): Response
    {
        if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($document);
            $entityManager->flush();
        }

        return $this->redirectToRoute('document_index', [], Response::HTTP_SEE_OTHER);
    }
}
