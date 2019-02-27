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
     * @Route("/profileapi", name="profile_api")
     */
    public function profileApi() {
        return new JsonResponse($this->getApiValues());
    }

    private function getApiValues() {
        $api_values = ['user' => $this->getProfileValues(), 'histories' => $this->getProjectHistories(), 'proficiencies' => $this->getProficiencies()];
        return $api_values;
    }

    private function getProfileValues() {


        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('p')
                ->from('App:Profile', 'p')
                ->where('p.user_id = :user_id')
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $profile_array = $query->getResult(Query::HYDRATE_ARRAY)[0];
        return $profile_array;
    }

    private function getProficiencies() {

        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('p')
                ->from('App:Proficiencies', 'p')
                ->where('p.profile = :user_id')
                ->orderby('p.percent')
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $proficiencies_array = $query->getResult(Query::HYDRATE_ARRAY);
        return $this->parseResultReturn($proficiencies_array);
    }

    private function getProjectHistories() {
        $query = $this->getEntityManager()->createQueryBuilder()
                ->select('p')
                ->from('App:ProjectHistory', 'p')
                ->where('p.profile = :user_id')
                ->orderby('p.start')
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $histories_array = $query->getResult(Query::HYDRATE_ARRAY);

        return $this->parseResultReturn($histories_array);
    }


    private function parseResultReturn($result_array) {
        $parsed_array = [];
        foreach ($result_array as $result) {
            $parsed_array[] = $result;
        }

        return $parsed_array;
    }

}
