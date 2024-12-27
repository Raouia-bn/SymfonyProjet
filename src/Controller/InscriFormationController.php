<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\InscriFormation;
use App\Entity\Session;
use App\Entity\User2;
use App\Form\InscriFormationType;
use App\Repository\InscriFormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\ExpressionLanguage\Token;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;


/**
 * @Route("/inscri/formation")
 */
class InscriFormationController extends AbstractController
{
    /**
     * @Route("/", name="inscri_formation_index", methods={"GET"})
     */
    public function index(InscriFormationRepository $inscriFormationRepository): Response
    {
        return $this->render('inscri_formation/index.html.twig', [
            'inscri_formations' => $inscriFormationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="inscri_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $inscriFormation = new InscriFormation();
        $form = $this->createForm(InscriFormationType::class, $inscriFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inscriFormation);
            $entityManager->flush();

            return $this->redirectToRoute('inscri_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscri_formation/new.html.twig', [
            'inscri_formation' => $inscriFormation,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/listinscrit", name="list_Inscrit", methods={"GET","POST"})
     */
    public function listInscri(Request $request): Response
    {
        $idUser=$this->getUser()->getId();
        $listInscrit=$this->getDoctrine()->getRepository(InscriFormation::class)->findBy(['candidate'=>$idUser]);
        return $this->renderForm('inscri_formation/list_Inscrit_Cand.html.twig', [
            'inscri_formations' => $listInscrit,
        ]);

    }
    /**
     * @Route("/confirmation/{id}", name="confirm_Inscrit", methods={"GET","POST"})
     */
    public function listInscri_confirmation(Request $request, int $id,  InscriFormationRepository $inscriFormationRepository): Response
    {

        $em= $this->getDoctrine()->getManager();
        $query= $em->createQuery('UPDATE App\Entity\InscriFormation i SET i.etat= : netat WHERE i.id = :'.$id.'');
        $query->setParameter('netat', 'valide');
        $query->setParameter('id', '$id');
        $query->execute();

        return $this->render('inscri_formation/index.html.twig', [
            'inscri_formations' => $inscriFormationRepository->findAll(),
        ]);

    }
    /**
     * @Route("/listinscritvalide", name="list_Inscrit_valide", methods={"GET","POST"})
     */
    public function listInscrivalid(Request $request): Response
    {
        $idUser=$this->getUser()->getId();
        $listInscrit=$this->getDoctrine()->getRepository(InscriFormation::class)->findBy(['candidate'=>$idUser,'etat'=>'valide']);
        return $this->renderForm('inscri_formation/index.html.twig', [
            'inscri_formations' => $listInscrit,
        ]);

    }
    /**
     * @Route("/listinscritnonvalide", name="list_Inscrit_nonvalide", methods={"GET","POST"})
     */
    public function listInscrinonvalid(Request $request): Response
    {

        $listInscrit=$this->getDoctrine()->getRepository(InscriFormation::class)->findBy(['etat'=>'pending']);
        return $this->renderForm('inscri_formation/inscritnonvalid_index.html.twig', [
            'inscri_formations' => $listInscrit,
        ]);

    }

    /**
     * @Route("/{id}", name="inscri_formation_show", methods={"GET"})
     */
    public function show(InscriFormation $inscriFormation): Response
    {
        return $this->render('inscri_formation/show.html.twig', [
            'inscri_formation' => $inscriFormation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="inscri_formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, InscriFormation $inscriFormation): Response
    {
        $form = $this->createForm(InscriFormationType::class, $inscriFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inscri_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inscri_formation/edit.html.twig', [
            'inscri_formation' => $inscriFormation,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="inscri_formation_delete", methods={"POST"})
     */
    public function delete(Request $request, InscriFormation $inscriFormation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inscriFormation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inscriFormation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inscri_formation_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    /**
     * @Route("/new/{id}", name="inscri_formation_new", methods={"GET","POST"})
     */
    public function newInscri(Request $request, Session $session): Response
    {
        //dump($token);die();
        //var_dump('$token');die();
        //$request->request->get('_token');

        $inscriFormation = new InscriFormation();

        $idUser = $this->getUser()->getId();
        $user = $this->getDoctrine()->getRepository(User2::class)->findOneBy(['id' => $idUser]);

        $etat = "pending";
        $formation=$session->getFormation();
        $inscriFormation->setCandidate($user);
        $inscriFormation->setEtat($etat);
        $inscriFormation->setNomFormation($formation->getNomf());
        $inscriFormation->setSession($session);


        $em = $this->getDoctrine()->getManager();
        $em->persist($inscriFormation);
        $em->flush();

        return $this->redirectToRoute('list_Inscrit');


       /* return $this->renderForm('inscri_formation/index.html.twig', [
            'inscri_formations' => $inscriFormation,

        ]);*/
    }

}
