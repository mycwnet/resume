<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    protected $entity_manager;

    /**
     * @Route("/main", name="main")
     */
    public function index() {

        if ($this->checkForUser()) {

            return $this->render('main/index.html.twig', [
                        'controller_name' => 'MainController',
            ]);
        } else {
            return $this->redirectToRoute('app_register');
        }
    }

    private function getEntityManager() {
        if (null === $this->entity_manager) {
            $this->entity_manager = $this->getDoctrine()->getManager();
        }

        return $this->entity_manager;
    }

    private function checkForUser() {
        return $this->getEntityManager()->createQueryBuilder()
                        ->select('u.id')
                        ->from('App:User', 'u')
                        ->setMaxResults(1)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

}
