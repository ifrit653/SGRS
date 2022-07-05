<?php

namespace App\Controller;

use App\Entity\Complaint;
use App\Form\ComplaintType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ComplaintController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @param ManagerRegistry $doctrine
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/complaint', name: 'complaint.index')]
    public function index(ManagerRegistry $doctrine, PaginatorInterface $paginator, Request $request): Response
    {

        $complaints = $paginator->paginate(
            $doctrine->getRepository(Complaint::class)->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('pages/complaint/index.html.twig', [
            'complaints' => $complaints,

        ]);
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/complaint/add', 'complaint.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $complaint = new Complaint();
        $form = $this->createForm(ComplaintType::class, $complaint);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $complaint = $form->getData();
            $manager->persist($complaint);
            $manager->flush();

            $this->addFlash(
                'success',
                'Complaint recorded'
            );

            return $this->redirectToRoute('complaint.index');
        }
        return $this->render('pages/complaint/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/complaint/edit/{id}', 'complaint.edit', methods: ['GET', 'POST'])]
    public function edit(Complaint $complaint, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ComplaintType::class, $complaint);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $complaint = $form->getData();
            $manager->persist($complaint);
            $manager->flush();

            $this->addFlash(
                'success',
                'Complaint Edited'
            );

            return $this->redirectToRoute('complaint.index');
        }
        return $this->render('pages/complaint/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/complaint/delete/{id}', 'complaint.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Complaint $complaint): Response
    {
        if (!$complaint) {
            $this->addFlash(
                'success',
                'Complaint not found'
            );
            return $this->redirectToRoute('complaint.index');
        }
        $manager->remove($complaint);
        $manager->flush();

        $this->addFlash(
            'success',
            'Complaint deleted'
        );
        return $this->redirectToRoute('complaint.index');
    }
}
