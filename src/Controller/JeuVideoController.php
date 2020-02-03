<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Entity\JeuVideo;
use App\Repository\AvisRepository;
use App\Repository\ConsoleRepository;
use App\Repository\JeuVideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JeuVideoController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ConsoleRepository $consoleRepository, JeuVideoRepository $jeuVideoRepository)
    {
        // Je récupere toutes mes consoles 
        $consoles = $consoleRepository->findAll();

        // Je récupère les 4 derniers jeux videos 
        $jeuVideos = $jeuVideoRepository->findHome(4);
        //$jeuVideoRepository->findBy([], ['id' => 'DESC'], 4);

        return $this->render('jeu_video/index.html.twig', [
            'consoles' => $consoles,
            'jeuVideos' => $jeuVideos,
        ]);
    }

    /**
     * @Route("/games/all", name="games_all")
     */
    public function all(JeuVideoRepository $jeuVideoRepository)
    {
        $jeuVideos = $jeuVideoRepository->findAll();

        return $this->render('jeu_video/game_all.html.twig', [
            'jeuVideos' => $jeuVideos,
        ]);
    }

    /**
     * @Route("/games/{id}", name="games_show")
     */
    public function show(JeuVideoRepository $jeuVideoRepository, AvisRepository $avisRepository, Request $request, $id)
    {
        $jeuVideo = $jeuVideoRepository->find($id);

        $user = $this->getUser();

        // je redirige vers une page 404
        if($jeuVideo == null) {
            throw $this->createNotFoundException('La page demandée n\'existe pas');
        }

        $avis = new Avis();

        $form_avis = $this->createForm(AvisType::class, $avis);

        $form_avis->handleRequest($request);

        // enregistrement des avis
        if ($form_avis->isSubmitted() &&  $form_avis->isValid()) {

            $avis->setUser($user)
                ->setJeu($jeuVideo);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($avis);

            $entityManager->flush();
            
        }

        // moyenne du jeu video 
        $moyenne = $avisRepository->findMoyenne($id);
        $avisList = $avisRepository->findBy(['jeu' => $id], ['id' => 'DESC']);

        return $this->render('jeu_video/game_show.html.twig', [
            'jeuvideo' => $jeuVideo,
            'form_avis' => $form_avis->createView(),
            'list_avis' => $avisList,
            'note'      => $moyenne
        ]);
    }

     /**
     * @Route("/avis/delete/{id}", name="avis_delete", methods={"DELETE"})
     */
    public function delete_avis(Request $request, Avis $avis)
    {
        $jeuVideo = $avis->getJeu();

        if ($this->isCsrfTokenValid('delete'.$avis->getId(), $request->request->get('_token'))) {
            // Je récupere l'entity manager 
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($avis);
            
            $entityManager->flush();
        }

        return $this->redirectToRoute('games_show', ['id' => $jeuVideo->getId()]);
    }

}
