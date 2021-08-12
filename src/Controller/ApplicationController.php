<?php


namespace App\Controller;


use App\Entity\Application;
use App\Entity\User;
use App\Form\ApplicationFormType;
use App\Form\RegistrationFormType;
use App\Service\ApplicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ApplicationController extends AbstractController
{
    protected ApplicationService $applicationService;

    /**
     * @param ApplicationService $applicationService
     */
    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }


    /**
     * @Route("/application", name="app_application_add")
     */
    public function add(Request $request): Response
    {
        $application = new Application();
        $form = $this->createForm(ApplicationFormType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applicationService->create($application);
            $this->addFlash('notice', 'Saved successfully!');
            return $this->redirectToRoute('app_application_add');
        }

        return $this->render('application/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
