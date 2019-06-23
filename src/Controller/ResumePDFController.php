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
    public function resumePDF() {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->isHtml5ParserEnabled(true);
        $pdfOptions->setFontHeightRatio(1.1);
        $pdfOptions->setTempDir("/var/www/html/devdothost/public/files/tmp");
        $pdfOptions->isRemoteEnabled(true);
        //$pdfOptions->setDebugCss(true);


        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $html = $this->getResumeHTML();

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $response = new Response($dompdf->output(['compress' => false]));

        $disposition = HeaderUtils::makeDisposition(
                        HeaderUtils::DISPOSITION_ATTACHMENT,
                        'resume.pdf'
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
        
    }

    /**
     * @Route("/resumepage", name="resumepage")
     */
    public function resumePage() {
        $html = $this->getResumeHTML();
        return new Response($html);
    }

    private function getResumeHTML() {
        $this->profile_data = new ProfileData($this->getEntityManager());
        $html = $this->renderView('pdf/resumepdf.html.twig', $this->profile_data->getApiValues());

        return $html;
    }

    private function getEntityManager() {
        if (null === $this->entity_manager) {
            $this->entity_manager = $this->getDoctrine()->getManager();
        }

        return $this->entity_manager;
    }

}
