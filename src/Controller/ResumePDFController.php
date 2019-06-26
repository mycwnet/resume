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
        
        $public_dir=$this->getParameter('kernel.project_dir') . '/public/'; 

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->isHtml5ParserEnabled(true);
        $pdfOptions->setFontHeightRatio(1.1);
        $pdfOptions->setTempDir($public_dir . "files/tmp");
        $pdfOptions->isRemoteEnabled(true);
        //$pdfOptions->setDebugCss(true);


        $dompdf = new Dompdf($pdfOptions);

        $html = $this->getResumeHTML();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

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
