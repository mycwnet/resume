<?php
namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class ProfileData {

    private $entity_manager;

    public function __construct(EntityManager $entity_manager) {
        $this->entity_manager = $entity_manager;
    }

    public function getApiValues() {
        $api_values = ['user' => $this->getProfileValues(),
            'configuration' => $this->getConfigurationValues(),
            'histories' => $this->getProjectHistories(),
            'proficiencies' => $this->getProficiencies(),
            'top_skills' => $this->getTopProficiencies(),
            'samples' => $this->getProjectSamples()
        ];
        return $api_values;
    }

    /**
     * Currently hard coded but may want to expand the app to allow multiple
     * users.
     */
    private function getUserId() {
        $query = $this->entity_manager->createQueryBuilder()
                ->select('u')
                ->from('App:User', 'u')
                ->getQuery();
        $user_array = $query->getResult(Query::HYDRATE_ARRAY);

        $this->user_id = $user_array[0]['id'];

        return $this->user_id;
    }

    private function getProfileValues() {


        $query = $this->entity_manager->createQueryBuilder()
                ->select('p')
                ->from('App:Profile', 'p')
                ->where('p.user_id = :user_id')
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $profile_array = $query->getResult(Query::HYDRATE_ARRAY)[0];
        $profile_array['image'] = basename($profile_array['image']);
        return $profile_array;
    }
    
    private function getTopProficiencies(){


        $query = $this->entity_manager->createQueryBuilder()
                ->select('p')
                ->from('App:Proficiencies', 'p')
                ->where('p.profile = :user_id')
                ->addorderby('p.percent', 'DESC')
                ->setMaxResults(10)
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $proficiencies_array = $query->getResult(Query::HYDRATE_ARRAY);
        $parsed_array = $this->parseResultReturn($proficiencies_array);
        return $parsed_array;
    
    }

    private function getProficiencies() {

        $query = $this->entity_manager->createQueryBuilder()
                ->select('p')
                ->from('App:Proficiencies', 'p')
                ->where('p.profile = :user_id')
                ->addorderby('p.category', 'DESC')
                ->addorderby('p.percent', 'DESC')
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $proficiencies_array = $query->getResult(Query::HYDRATE_ARRAY);
        $parsed_array = $this->parseResultReturn($proficiencies_array);
        return $this->proficienciesByCategory($parsed_array);
    }

    private function proficienciesByCategory($proficiencies_array) {
        $categorized_array = [];
        foreach ($proficiencies_array as $proficiency) {
            $category = $proficiency['category'] ? $proficiency['category'] : 'other';
            $categorized_array[$category][] = $proficiency;
        }
        return $categorized_array;
    }

    private function getProjectSamples() {
        $query = $this->entity_manager->createQueryBuilder()
                ->select('ps')
                ->from('App:ProjectSamples', 'ps')
                ->where('ps.profile = :user_id')
                ->orderby('ps.index')
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $samples_array = $query->getResult(Query::HYDRATE_ARRAY);

        return $this->parseResultReturn($this->setSampleImages($samples_array));
    }

    private function getProjectHistories() {
        $query = $this->entity_manager->createQueryBuilder()
                ->select('p')
                ->from('App:ProjectHistory', 'p')
                ->where('p.profile = :user_id')
                ->orderby('p.start')
                ->setParameter('user_id', $this->getUserId())
                ->getQuery();

        $histories_array = $query->getResult(Query::HYDRATE_ARRAY);
        foreach ($histories_array as $key => $history) {
            $histories_array[$key]['start'] = $history['start']->format($this->date_format);
            $histories_array[$key]['end'] = $history['end'] ? $history['end']->format($this->date_format) : 'Present';
        }
        return $this->parseResultReturn($histories_array);
    }

    private function parseResultReturn($result_array) {
        $parsed_array = [];
        foreach ($result_array as $result) {
            $parsed_array[] = $result;
        }

        return $parsed_array;
    }

    private function setDateFormat($date_format_variable) {

        switch ($date_format_variable) {
            case "1":
                $this->date_format = 'M jS, Y';

                break;
            case "2":
                $this->date_format = 'm d y';

                break;
            case "3":
                $this->date_format = 'm d Y';

                break;
            case "4":

                $this->date_format = 'Y M jS';

                break;
            case "5":

                $this->date_format = 'y m d';
                break;
            case "6":
                $this->date_format = 'Y m d';

                break;
            case "7":
                $this->date_format = 'jS M Y';

                break;
            case "8":
                $this->date_format = 'd m y';

                break;
            case "9":
                $this->date_format = 'd m y';

                break;
            default:
                $this->date_format = 'M jS, Y';
                break;
        }
    }

    private function getConfigurationValues() {
        $query = $this->entity_manager->createQueryBuilder()
                ->select('c')
                ->from('App:Configuration', 'c')
                ->where('c.index = :id')
                ->setParameter('id', $this->user_id)
                ->getQuery();

        $configuration_aray = $query->getResult(Query::HYDRATE_ARRAY)[0];
        $this->setDateFormat($configuration_aray['dateformat']);
        $configuration_aray['background_image'] = basename($configuration_aray['background_image']);
        $configuration_aray['site_logo'] = basename($configuration_aray['site_logo']);
        $configuration_aray['favicon_image'] = basename($configuration_aray['favicon_image']);
        return $configuration_aray;
    }

    private function setSampleImages($samples) {

        foreach ($samples as $key => $sample) {
            if (array_key_exists('project_image', $sample) && !empty($sample['project_image'])) {
                $samples[$key]['project_image'] = basename($sample['project_image']);
            }
        }

        return $samples;
    }

}
