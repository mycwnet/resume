<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\Type\ProfileType;
use App\Entity\ProjectHistory;
use App\Entity\Proficiencies;
use App\Entity\ProjectSamples;
use App\Entity\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use App\Service\FileUploader;
use Symfony\Component\Filesystem\Filesystem;
use Psr\Log\LoggerInterface;

class ProfileController extends AbstractController {

    protected $entity_manager;
    protected $profile;
    protected $user;
    protected $current_avatar;
    protected $current_background;
    protected $current_site_logo;
    protected $current_favicon;
    protected $project_images;
    protected $current_color;
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
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
        $this->logger->info("user id: " . $user->getId());
        $filesystem = new Filesystem();

        if (null === $this->profile) {
            $this->profile = $this->getEntityManager()
                    ->getRepository('App:Profile')
                    ->findOneBy(['user_id' => $user->getId()]);
            var_dump($this->profile);
            if ($this->profile && $this->profile->getImage() && $filesystem->exists($this->profile->getImage())) {
                $this->profile->setImage(new File($this->profile->getImage()));
                $this->current_avatar = $this->profile->getImage();
            } else {
                $this->profile = new Profile();
                $this->profile->setUserId($user);
            }
        }
        return $this->profile;
    }

    /**
     * Matches /profile exactly
     *
     * @Route("/profile", name="resume_profile")
     */
    public function new(Request $request) {

        $background_filename = null;
        $avatar_filename = null;
        $site_logo_filename = null;
        $favicon_filename = null;
        $sample_exists = [];
        $filesystem = new Filesystem();
        $user = $this->getUser();
        $persist=false;

        if ($user->getId()) {
            $profile = $this->getProfile();
            $this->loadHistories();
            $this->loadProficiencies();
            $this->loadConfiguration();
            $this->loadProjectSamples();
            $background_filename = $this->current_background && $filesystem->exists($this->getParameter('images_directory') . '/' . $this->current_background->getBasename()) ? $this->current_background->getBasename() : null;
            $site_logo_filename = $this->current_site_logo && $filesystem->exists($this->getParameter('images_directory') . '/' . $this->current_site_logo->getBasename()) ? $this->current_site_logo->getBasename() : null;
            $favicon_filename = $this->current_favicon && $filesystem->exists($this->getParameter('images_directory') . '/' . $this->current_favicon->getBasename()) ? $this->current_favicon->getBasename() : null;
            $avatar_filename = $this->current_avatar && $filesystem->exists($this->getParameter('images_directory') . '/' . $this->current_avatar->getBasename()) ? $this->current_avatar->getBasename() : null;
            foreach ($this->project_images as $key => $project_image) {
                $sample_exists[$key] = $project_image->getBasename();
            }
        } else {
            $persist=true;
            $profile = new Profile();
            $profile->setUserId($user);
            $project_history = new ProjectHistory();
            $proficiency = new Proficiencies();
            $project_sample = new ProjectSamples();
            $profile->addProjectHistory($project_history);
            $profile->addProficiency($proficiency);
            $profile->addProjectSample($project_sample);
        }

        $form = $this->createForm(ProfileType::class, $profile);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {


            $new_avatar = $this->uploadImage($form, 'image', $this->current_avatar, 'avatar');
            if ($new_avatar) {
                $profile->setImage(new File($this->getParameter('images_directory') . '/' . $new_avatar));
                $avatar_filename = $new_avatar;
            }
            $new_background = $this->uploadImage($form, 'background_image', $this->current_background, 'background', 'configuration');
            if ($new_background) {
                $profile->getConfiguration()->setBackgroundImage(new File($this->getParameter('images_directory') . '/' . $new_background));
                $background_filename = $new_background;
            }

            $new_logo = $this->uploadImage($form, 'site_logo', $this->current_site_logo, 'site_logo', 'configuration');
            if ($new_logo) {
                $profile->getConfiguration()->setSiteLogo(new File($this->getParameter('images_directory') . '/' . $new_logo));
                $site_logo_filename = $new_logo;
            }

            $new_favicon = $this->uploadImage($form, 'favicon_image', $this->current_favicon, 'favicon', 'configuration');
            if ($new_favicon) {
                $profile->getConfiguration()->setFaviconImage(new File($this->getParameter('images_directory') . '/' . $new_favicon));
                $favicon_filename = $new_favicon;
            }

            $new_color = $form->get('configuration')->get('color')->getData();
            if ($new_color !== $this->current_color) {
                $rgb = $this->hexToRGB($new_color);
                $base_color = '$baseColor: rgb(' . $rgb['r'] . ', ' . $rgb['g'] . ', ' . $rgb['b'] . ');';
                $filesystem->dumpFile('../assets/css/sass/baseColor.scss', $base_color);
                $shell_return = exec('yarn encore production');
            }

            $project_samples = $form->get('project_samples');
            foreach ($project_samples as $project_sample) {
                $project_image = $project_sample->get('project_image')->getData();
                $sample_entity = $project_sample->getViewData();
                $sample_index = $sample_entity->getSampleIndex();


                if ($project_image && $sample_index) {
                    $current_project_image = array_key_exists($sample_index, $this->project_images) && is_object($this->project_images[$sample_index]) ? $this->project_images[$sample_index]->getBasename() : null;
                    $sample_uploader = new FileUploader('images_directory/project_samples', $current_project_image);
                    $sample_filename = $sample_uploader->upload($project_image);
                    $sample_exists[$sample_index] = $sample_filename;
                    $sample_entity->setProjectImage(new File($this->getParameter('images_directory') . '/project_samples/' . $sample_filename));
                }
            }
            if($persist){$this->getEntityManager()->persist($profile);}
            $this->getEntityManager()->flush();
        }


        return $this->render('profile/profile.html.twig', [
                    'form' => $form->createView(),
                    'avatar_exists' => $avatar_filename,
                    'background_exists' => $background_filename,
                    'site_logo_exists' => $site_logo_filename,
                    'favicon_exists' => $favicon_filename,
                    'sample_exists' => $sample_exists
        ]);
    }

    /**
     *    
     * Upload a single image
     * 
     *
     * @param object $form form object
     * @param string $image_name machine name of the image
     * @param object $current_image current image object (e.g. $this->current_background)
     * @param string $prefix (optional) prefix to the image name
     * @param string $form_name (optional) machine name of the form (if not provided uses the base form)
     * @return string filename of image
     */
    private function uploadImage($form, $image_name, $current_image, $prefix = null, $form_name = null) {
        $image = $form_name ? $form->get($form_name)->get($image_name)->getData() : $form->get($image_name)->getData();
        $image_filename = null;
        if ($image) {
            $current_image_name = $current_image && is_object($current_image) ? $current_image->getBasename() : null;
            $image_uploader = new FileUploader('images_directory', $current_image_name);
            $image_filename = $image_uploader->upload($image, $prefix);
        }

        return $image_filename;
    }

    private function hexToRGB($hex) {

        list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        return ['r' => $r, 'g' => $g, 'b' => $b];
    }

    private function loadHistories() {
        $project_histories = $this->getEntityManager()->getRepository('App:ProjectHistory')->findAll();
        if (count($project_histories) > 0) {
            foreach ($project_histories as $project_history) {
                $this->profile->addProjectHistory($project_history);
            }
        } else {
            $project_history = new ProjectHistory();
            $this->profile->addProjectHistory($project_history);
        }
    }

    private function loadProficiencies() {
        $proficiencies = $this->getEntityManager()->getRepository('App:Proficiencies')->findAll();
        if (count($proficiencies) > 0) {
            foreach ($proficiencies as $proficiency) {
                $this->profile->addProficiency($proficiency);
            }
        } else {
            $proficiency = new Proficiencies();
            $this->profile->addProficiency($proficiency);
        }
    }

    private function loadProjectSamples() {
        $this->project_images = [];
        $filesystem = new Filesystem();
        $project_samples = $this->getEntityManager()->getRepository('App:ProjectSamples')->findAll();
        if (count($project_samples) > 0) {
            foreach ($project_samples as $project_sample) {
                if ($project_sample->getTitle()) {
                    $project_sample->setSampleIndex($project_sample->getIndex());
                    if ($project_sample->getSampleIndex() && $project_sample->getProjectImage() && $filesystem->exists($project_sample->getProjectImage())) {
                        $this->project_images[$project_sample->getIndex()] = new File($project_sample->getProjectImage());
                    }
                    $this->profile->addProjectSample($project_sample);
                } else {
                    $this->profile->removeProjectSample($project_sample);
                }
            }
        } else {
            $project_sample = new ProjectSamples();
            $project_sample->setSampleIndex(md5(uniqid()));
            $this->profile->addProjectSample($project_sample);
        }
    }

    private function loadConfiguration() {
        $user = $this->getUser();
        $filesystem = new Filesystem();
        $configuration = $this->getEntityManager()->getRepository('App:Configuration')->findOneBy(['index' => $user->getId()]);
        if ($configuration) {
            if ($configuration->getBackgroundImage() && $filesystem->exists($configuration->getBackgroundImage())) {
                $configuration->setBackgroundImage(new File($configuration->getBackgroundImage()));
                $this->current_background = $configuration->getBackgroundImage();
            }
            if ($configuration->getColor()) {
                $this->current_color = $configuration->getColor();
            }
            if ($configuration->getSiteLogo()) {
                $configuration->setSiteLogo(new File($configuration->getSiteLogo()));
                $this->current_site_logo = $configuration->getSiteLogo();
            }
            if ($configuration->getFaviconImage()) {
                $configuration->setFaviconImage(new File($configuration->getFaviconImage()));
                $this->current_favicon = $configuration->getFaviconImage();
            }
            $this->profile->setConfiguration($configuration);
        } else {
            $configuration = new Configuration();
            $configuration->setIndex($user->getId());
            $this->profile->setConfiguration($configuration);
        }
    }

}
