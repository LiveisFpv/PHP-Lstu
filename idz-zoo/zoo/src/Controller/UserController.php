<?php

namespace App\Controller;

use App\Service\UserPdfGenerator;
use App\Entity\User;
use App\Form\UserForm;
use App\Form\UserFilterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route(name: 'app_user_index', methods: ['GET'])]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserFilterType::class);
        $form->handleRequest($request);
        $filters = $form->isSubmitted() && $form->isValid() ? $form->getData() : [];

        $sort = $request->query->get('sort', 'id');
        $direction = $request->query->get('direction', 'asc');

        $users = $userRepository->findByFiltersAndSort($filters, $sort, $direction);

        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
            'currentDirection' => $direction,
        ]);
    }

    #[Route('/pdf', name: 'app_user_generate_pdf', methods: ['GET'])]
    public function pdf(Request $request, UserRepository $userRepository): Response
    {
        $filters = [];
        if ($request->query->has('filters')) {
            $rawFilters = $request->query->all()['filters'];
            foreach ($rawFilters as $key => $value) {
                if ($value !== null && $value !== '') {
                    $filters[$key] = $value;
                }
            }
        }

        $sort = $request->query->get('sort', 'id');
        $direction = $request->query->get('direction', 'asc');

        $users = $userRepository->findByFiltersAndSort($filters, $sort, $direction);

        $pdfContent = UserPdfGenerator::generatePdf($users);

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="users.pdf"',
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $user->setUserPassword($passwordHasher->hashPassword($user, $plainPassword));
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_user_show', [
                'id' => $user->getId(),
                'user' => $user,
                'form' => $form,],
             Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->getString('_token'))) {
            
            if ($this->getUser() && $user === $this->getUser()) {
                $session = $request->getSession();
                $session->invalidate();
                $this->container->get('security.token_storage')->setToken(null);
                $entityManager->remove($user);
                $entityManager->flush();
                return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
            }

            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

}
