<?php

namespace App\Controller;

use App\Service\AnimalPdfGenerator;
use App\Entity\Animal;
use App\Entity\Care;
use App\Form\AnimalForm;
use App\Form\AnimalFilterType;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/animal')]
final class AnimalController extends AbstractController
{
    #[Route(name: 'app_animal_index', methods: ['GET'])]
    public function index(Request $request, AnimalRepository $animalRepository): Response
    {
        $form = $this->createForm(AnimalFilterType::class);
        $form->handleRequest($request);

        $filters = $form->isSubmitted() && $form->isValid() ? $form->getData() : [];

        $sort = $request->query->get('sort', 'animalName');
        $direction = $request->query->get('direction', 'asc');

        $animals = $animalRepository->findByFiltersAndSort($filters, $sort, $direction);

        return $this->render('animal/index.html.twig', [
            'form' => $form->createView(),
            'animals' => $animals,
            'currentDirection' => $direction,
        ]);
    }

    #[Route('/pdf', name: 'app_animal_generate_pdf', methods: ['GET'])]
    public function pdf(Request $request, AnimalRepository $animalRepository): Response
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

        $sort = $request->query->get('sort', 'animalName');
        $direction = $request->query->get('direction', 'asc');

        $animals = $animalRepository->findByFiltersAndSort($filters, $sort, $direction);

        $pdfContent = AnimalPdfGenerator::generatePdf($animals);

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="animals.pdf"',
        ]);
    }

    #[Route('/new', name: 'app_animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = new Animal();
        $careAnimals = $entityManager->getRepository(Care::class)->findAll();
        $animalChoices = [];
        foreach ($careAnimals as $care) {
            $animalChoices[$care->getAnimalName()] = $care;
        }
        $form = $this->createForm(AnimalForm::class, $animal, [
            'animal_choices' => $animalChoices,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $care = $entityManager->getRepository(Care::class)->find($animal->getCare());
            $animal->setCare($care);
            $entityManager->persist($animal);
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal/new.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_show', methods: ['GET'])]
    public function show(Animal $animal): Response
    {
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animal $animal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnimalForm::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_delete', methods: ['POST'])]
    public function delete(Request $request, Animal $animal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animal_index', [], Response::HTTP_SEE_OTHER);
    }
}
