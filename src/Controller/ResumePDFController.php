<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ProfileData;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Dompdf\Options;

class ResumePDFController extends AbstractController {

    protected $profile_data;
    protected $entity_manager;

    /**
     * @Route("/resumepdf", name="resumepdf")
     */
    public function index() {
        $this->profile_data = new ProfileData($this->getEntityManager());

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->isHtml5ParserEnabled(true);
        $pdfOptions->setFontHeightRatio(1.1);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('pdf/resumepdf.html.twig', $this->profile_data->getApiValues());

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
       

        // Render the HTML as PDF
        $dompdf->render();

        $response = new Response($dompdf->output(['compress'=>false]));

        $disposition = HeaderUtils::makeDisposition(
                        HeaderUtils::DISPOSITION_ATTACHMENT,
                        'resume.pdf'
        );

       $response->headers->set('Content-Disposition', $disposition);
    //   return new Response($html);
       return $response;
    }

    private function getEntityManager() {
        if (null === $this->entity_manager) {
            $this->entity_manager = $this->getDoctrine()->getManager();
        }

        return $this->entity_manager;
    }

}
