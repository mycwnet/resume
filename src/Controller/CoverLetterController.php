<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ProfileData;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Dompdf;
use Dompdf\Options;

class CoverLetterController extends AbstractController {

    protected $profile_data;
    protected $entity_manager;

    /**
     * @Route("/coverletterpdf", name="coverletterpdf")
     */
    public function coverLetterPDF() {
        
        $public_dir=$this->getParameter('kernel.project_dir') . '/public/'; 

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->isHtml5ParserEnabled(true);
        $pdfOptions->setFontHeightRatio(1.1);
        $pdfOptions->setTempDir($public_dir . "files/tmp");
        $pdfOptions->isRemoteEnabled(true);
        //$pdfOptions->setDebugCss(true);


        $dompdf = new Dompdf($pdfOptions);

        $html = $this->getCoverLetterHTML();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $response = new Response($dompdf->output(['compress' => false]));

        $disposition = HeaderUtils::makeDisposition(
                        HeaderUtils::DISPOSITION_ATTACHMENT,
                        'coverletter.pdf'
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
        
    }

    /**
     * @Route("/coverletterpage", name="coverletterpage")
     */
    public function coverLetterPage() {
        $html = $this->getCoverLetterHTML();
        return new Response($html);
    }

    private function getCoverLetterHTML() {
        $this->profile_data = new ProfileData($this->getEntityManager());
        $sflkjds= $this->profile_data->getApiValues();
        $html = $this->renderView('pdf/coverletterpdf.html.twig', $this->profile_data->getApiValues());

        return $html;
    }

    private function getEntityManager() {
        if (null === $this->entity_manager) {
            $this->entity_manager = $this->getDoctrine()->getManager();
        }

        return $this->entity_manager;
    }

}

