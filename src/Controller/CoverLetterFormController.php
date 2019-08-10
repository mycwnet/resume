<?php

namespace App\Controller;

use App\Entity\CoverLetter;
use App\Form\Type\CoverLetterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Psr\Log\LoggerInterface;



class CoverLetterFormController extends AbstractController{
    protected $entity_manager;
    protected $profile;
    protected $user;
    protected $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    private function getEntityManager() {
        if (null === $this->entity_manager) {
            $this->entity_manager = $this->getDoctrine()->getManager();
        }

        return $this->entity_manager;
    }

    private function getProfile() {
        $user = $this->getUser();
        if (null === $this->profile) {
            $this->profile = $this->getEntityManager()
                    ->getRepository('App:Profile')
                    ->findOneBy(['user_id' => $user->getId()]);
        }
        return $this->profile;
    }

    /**
     * Matches /coverletterform exactly
     *
     * @Route("/coverletterform", name="coverletterform")
     */
    public function new(Request $request) {

        $user = $this->getUser();

        if ($user->getId()) {
            $profile = $this->getProfile();
            $this->loadCoverLetter();
            $cover_letter = $profile->getCoverLetter();
            

        }

        $form = $this->createForm(CoverLetterType::class, $cover_letter);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            $this->getEntityManager()->flush();
            return $this->redirectToRoute('coverletterpage');
        }


        return $this->render('coverletter/coverletter.html.twig', [
                    'form' => $form->createView()
        ]);
    }

    private function loadCoverLetter() {
        $user = $this->getUser();
        $cover_letter = $this->getEntityManager()->getRepository('App:CoverLetter')->findOneBy(['index' => $user->getId()]);
        if ($cover_letter) {
            $this->profile->setCoverLetter($cover_letter);
        } else {
            $cover_letter = new CoverLetter();
            $cover_letter->setIndex($user->getId());
            $this->profile->setCoverLetter($cover_letter);
        }
    }
}
