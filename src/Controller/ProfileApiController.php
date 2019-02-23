<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\Query;

class ProfileApiController extends AbstractController {

    protected $entity_manager;
    protected $user_id;

    private function getEntityManager() {
        if (null === $this->entity_manager) {
            $this->entity_manager = $this->getDoctrine()->getManager();
        }

        return $this->entity_manager;
    }

    /**
     * Currently hard coded but may want to expand the app to allow multiple
     * users.
     */
    private function getUserId() {
        if (null === $this->user_id) {
            $this->user_id = 2;
        }

        return $this->user_id;
    }

    /**
     * @Route("/profileapi")
     */
    public function profileApi() {
        return new JsonResponse($this->getApiValues());
    }

    private function getApiValues() {
        return ['user'=>$this->getProfileValues(), 'histories'=> $this->getProjectHistories(), 'proficiencies'=> $this->getProficiencies()];
        
    }

    private function getProfileValues() {


        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('p')
                ->from('App:Profile','p')
                ->where('p.user_id = :user_id')
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $profile_array = $query->getResult(Query::HYDRATE_ARRAY);


        return $profile_array;
    }

    private function getProficiencies() {
        
        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('p')
                ->from('App:Proficiencies','p')
                ->where('p.profile = :user_id')
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $proficiencies_array = $query->getResult(Query::HYDRATE_ARRAY);


        return $proficiencies_array;
    }

    private function getProjectHistories() {
                $query = $this->getEntityManager()->createQueryBuilder()
                ->select('p')
                ->from('App:ProjectHistory','p')
                ->where('p.profile = :user_id')
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $histories_array = $query->getResult(Query::HYDRATE_ARRAY);


        return $histories_array;
    }

}
