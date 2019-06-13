<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\ProfileData;

class ProfileApiController extends AbstractController {

    protected $entity_manager;
    protected $user_id;
    protected $date_format;
    protected $profile_data;

    private function getEntityManager() {
        if (null === $this->entity_manager) {
            $this->entity_manager = $this->getDoctrine()->getManager();
        }

        return $this->entity_manager;
    }

    /**
     * @Route("/profileapi", name="profile_api")
     */
    public function profileApi() {
        return new JsonResponse($this->getApiValues());
    }

    private function getApiValues() {
        $this->profile_data=new ProfileData($this->getEntityManager());
        $data=$this->profile_data->getApiValues();
        
        $api_values = ['user' => $this->getProfileValues($data['user']),
            'configuration' => $data['configuration'],
            'histories' => $data['histories'],
            'proficiencies' => $data['proficiencies'],
            'samples' => $data['samples']
        ];
        return $api_values;
    }

    private function getProfileValues($profile_array) {

        $profile_array['background'] = $this->createPagesArray($profile_array['background'], 2100, ["/p>", "/ul>", "/ol>"]);
        return $profile_array;
    }

    /**
     * Takes a string and breaks it down to the closest break pattern before a
     * max length in characters is reached.
     * 
     * @param string $text The text to be broken down
     * @param int $max_length Page length in characters
     * @param array $break_patterns an array of strings to break at
     * @param array $page_array Used for recursion (not user provided)
     * @return array An array of pages
     */
    private function createPagesArray($text, $max_length = 2100, $break_patterns = [". "], $page_array = []) {
        if (strlen($text) > $max_length) {
            $position = 0;
            foreach ($break_patterns as $break_pattern) {
                $add_capture = strlen($break_pattern);
                $new_position = strrpos($text, $break_pattern, $max_length - strlen($text)) + $add_capture;
                $position = $new_position > $position ? $new_position : $position;
            }
            $page_array[] = substr($text, 0, $position);
            $page_array = $this->createPagesArray(substr($text, $position), $max_length, $break_patterns, $page_array);
        } else {
            $page_array[] = $text;
        }

        return $page_array;
    }

}
