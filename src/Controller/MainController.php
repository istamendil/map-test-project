<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Some bin controller: actions goes here before getting own controller due to too many actions of one logic group.
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ContainerBagInterface $c)
    {
        return $this->render('index.html.twig', [
            'mapCenter' => $c->get('app.yandex.map_center'), //Could be guessed depending on loading data etc. So now it's only param.
        ]);
    }

}
