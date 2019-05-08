<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query;

class MainController extends AbstractController {

    protected $entity_manager;
    protected $user_id;

    /**
     * @Route("/main", name="main")
     */
    public function index() {

        if ($this->checkForUser()) {
            $this->getUserId();

            return $this->render('main/index.html.twig', [
                        'controller_name' => 'MainController',
                        'configuration' => $this->getConfiguration()
            ]);
        } else {
            return $this->redirectToRoute('app_register');
        }
    }

    private function getConfiguration() {
        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('c')
                ->from('App:Configuration', 'c')
                ->where('c.index = :id')
                ->setParameter('id', $this->user_id)
                ->getQuery();

        $configuration_aray = $query->getResult(Query::HYDRATE_ARRAY)[0];
        $configuration_aray['background_image'] = basename($configuration_aray['background_image']);
        $configuration_aray['site_logo'] = basename($configuration_aray['site_logo']);
        $configuration_aray['favicon_image'] = basename($configuration_aray['favicon_image']);
        return $configuration_aray;
    }

    /**
     * Currently hard coded but may want to expand the app to allow multiple
     * users.
     */
    private function getUserId() {
        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('u')
                ->from('App:User', 'u')
                ->getQuery();
        $user_array = $query->getResult(Query::HYDRATE_ARRAY);

        $this->user_id = $user_array[0]['id'];

        return $this->user_id;
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
