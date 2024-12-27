<?php

namespace App\Controller;

use App\Entity\User2;
use App\Entity\Users;
use App\Form\User2Type;
use App\Form\UsersType;
use App\Repository\User2Repository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
/**
 * @Route("/users")
 */
class UsersController extends AbstractController
{
    private $passwordEncoder;

    /**
     * @Route("/", name="user2_index", methods={"GET"})
     */
    public function index(User2Repository $userRepository): Response
    {
        return $this->render('user2/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user2_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User2();
        $form = $this->createForm(User2Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->passwordEncoder->encodePassword($form->get()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user2/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user2_show", methods={"GET"})
     */
    public function show(User2 $user): Response
    {
        return $this->render('user2/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user2_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User2 $user, UserPasswordHasherInterface $passwordHasher, User2Repository $user2Repository): Response
    {
        $form = $this->createForm(User2Type::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user2 = new User2();
            $userInfo = $form->getData();
            //dump($form->getData());die();
            $username = $userInfo->getEmail();
            $plainPassword = $userInfo->getPassword();
            $user->setPassword($plainPassword);
            $user2 = $user2Repository->findOneBy(['email' => $username]);
            if ($user2 === null) {
                $this->addFlash('danger', 'Invalid username');
                return $this->redirectToRoute('forgot');
            }
            /*dump($user);
            dump($plainPassword);
            die();*/
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plainPassword
            );
            $user2->setPassword($hashedPassword);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user2/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user2_delete", methods={"POST"})
     */
    public function delete(Request $request, User2 $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user2_index', [], Response::HTTP_SEE_OTHER);
    }
}
