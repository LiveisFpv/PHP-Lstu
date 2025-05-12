<?php

namespace App\Controller;

use App\Service\TicketPdfGenerator;
use App\Entity\Ticket;
use App\Form\TicketForm;
use App\Form\TicketFilterType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Fawno\FPDF\FawnoFPDF;

#[Route('/ticket')]
final class TicketController extends AbstractController
{

    #[Route(name: 'app_ticket_index', methods: ['GET'])]
    public function index(Request $request,TicketRepository $ticketRepository): Response
    {
        $user = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(TicketFilterType::class);
            $form->handleRequest($request);
            $filters = $form->isSubmitted() && $form->isValid() ? $form->getData() : [];
            $sort = $request->query->get('sort', 'id');
            $direction = $request->query->get('direction', 'asc');
            $tickets = $ticketRepository->findByFiltersAndSort($filters, $sort, $direction);
            return $this->render('ticket/index.html.twig', [
                'form' => $form->createView(),
                'tickets' => $tickets,
                'currentDirection' => $direction,
            ]);
        } else {
            $email = $user?->getUserIdentifier();
            if (!$email) {
                $tickets = [];
            } else {
                $currentDate = new \DateTime();
                $oneWeekAgo = (clone $currentDate)->modify('-1 week');
                $tickets = $ticketRepository->createQueryBuilder('t')
                ->where('t.userEmail = :email')
                ->andWhere('t.ticketDate >= :oneWeekAgo')
                ->setParameter('email', $email)
                ->setParameter('oneWeekAgo', $oneWeekAgo)
                ->orderBy('t.ticketDate', 'ASC')
                ->addOrderBy('t.ticketTime', 'ASC')
                ->getQuery()
                ->getResult();
            }
            return $this->render('ticket/index.html.twig', [
                'tickets' => $tickets,
            ]);
        }   
    }

    #[Route('/pdf', name: 'app_ticket_generate_pdf', methods: ['GET'])]
    public function pdf(Request $request, TicketRepository $ticketRepository): Response
    {
        $user = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
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
            $tickets = $ticketRepository->findByFiltersAndSort($filters, $sort, $direction);
        } else {
            $email = $user?->getUserIdentifier();
            if (!$email) {
                $tickets = [];
            } else {
                $currentDate = new \DateTime();
                $oneWeekAgo = (clone $currentDate)->modify('-1 week');
                $tickets = $ticketRepository->createQueryBuilder('t')
                ->where('t.userEmail = :email')
                ->andWhere('t.ticketDate >= :oneWeekAgo')
                ->setParameter('email', $email)
                ->setParameter('oneWeekAgo', $oneWeekAgo)
                ->orderBy('t.ticketDate', 'ASC')
                ->addOrderBy('t.ticketTime', 'ASC')
                ->getQuery()
                ->getResult();
            }
        }
        
        $pdfContent = TicketPdfGenerator::generatePdf($tickets);
        
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="tickets.pdf"',
        ]);
        
    }

    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketForm::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketForm::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
