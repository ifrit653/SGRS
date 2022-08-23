<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Complaint;

use App\Repository\AnswerRepository;
use App\Repository\ComplaintRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Config\Framework\HttpClient\DefaultOptions\RetryFailedConfig;

class AnswerController extends AbstractController
{
    #[Route('/answer', name: 'answer.index')]
    public function index(ManagerRegistry $doctrine, PaginatorInterface $paginator, Request $request): Response
    {
        $answers = $paginator->paginate(
            $doctrine->getRepository(Answer::class)->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('pages/answer/index.html.twig', [
            'answers' => $answers
        ]);
    }

    #[Route('/answer/new/{id}', 'answer.new', methods: ['GET', 'POST'])]
    public function new(int $id, ComplaintRepository $repository, Request $request, EntityManagerInterface $manager): Response
    {
        $answer = new Answer();
        $answer->setComplaint($repository->findOneBy(['id' => $id]));

        $form = $this->createFormBuilder($answer)
            ->add('solution', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Solution',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'submit',
            ])
            ->getForm();



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $answer = $form->getData();
            $manager->persist($answer);
            $manager->flush();

            $this->addFlash(
                'success',
                'Answer recorded'
            );

            return $this->redirectToRoute('answer.index');
        }
        return $this->render('pages/answer/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
