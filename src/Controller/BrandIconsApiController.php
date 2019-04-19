<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Config\FileLocator;

class BrandIconsApiController extends AbstractController {

    /**
     * @Route("/brandicons", name="brand_icons")
     */
    public function brandIconsApi() {
        return new JsonResponse($this->getApiValues());
    }

    /**
     * @Route("/brandicons/{search}", name="brand_icons_search")
     */
    public function brandIconsSearchApi($search) {
        return new JsonResponse($this->getBestMatches($search));
    }

    private function getApiValues() {
        $json_array = $this->loadFile();
        $return_array = [];
        foreach ($json_array as $icon => $values) {
            if (in_array('brands', $values['styles'])) {
                $name = str_replace('-', ' ', str_replace('-alt', '', str_replace('-square', '', $icon)));

                $terms = [$name];
                if (strcasecmp($name, 'js') === 0) {
                    $terms[] = 'javascript';
                }
                foreach ($values['search']['terms'] as $term) {
                    $search_term = str_replace('-', ' ', str_replace('-square', '', $term));

                    $terms[] = $search_term;
                }
                $return_array[$icon] = ['name' => $icon, 'terms' => $terms];
            }
        }

        return $return_array;
    }

    public function getBestMatches($proficiency) {
        $api_values = $this->getApiValues();
        $regex = $this->getSearchRegex($proficiency);
        $matches = [];
        $icons = [];
        foreach ($api_values as $icon => $icon_values) {
            foreach ($icon_values['terms'] as $term) {
                preg_match($regex, $term, $matches);
                if ($matches) {
                    $icons[$icon] = $icon;
                }
            }
        }
        return $icons;
    }

    private function getSearchRegex($proficiency) {
        $proficiency_array = explode(' ', $proficiency);
        $regex = "/(";
        $count = 0;
        foreach ($proficiency_array as $term) {

            $regex .= $count > 0 ? "|^" . $term : "^" . $term;
            $count++;
        }
        $regex .= ")/i";

        return $regex;
    }

    private function loadFile() {
        $dataDir = '../vendor/fortawesome/font-awesome/metadata';

        $fileLocator = new FileLocator($dataDir);
        $iconFile = $fileLocator->locate('icons.json', null, false)[0];

        $json_array = json_decode(file_get_contents($iconFile), true);

        return $json_array;
    }

}
