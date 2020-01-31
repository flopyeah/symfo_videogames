<?php

namespace App\Controller;

use App\Repository\ConsoleRepository;
use App\Repository\JeuVideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class JeuVideoController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ConsoleRepository $consoleRepository, JeuVideoRepository $jeuVideoRepository)
    {
        $consoles = $consoleRepository->findAll();
        $jeuVideos = $jeuVideoRepository->findHome(4);

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
    public function show(JeuVideoRepository $jeuVideoRepository, $id)
    {
        $jeuVideo = $jeuVideoRepository->find($id);

        // je redirige vers une page 404
        if($jeuVideo == null) {
            throw $this->createNotFoundException('La page demandée n\'existe pas');
        }

        return $this->render('jeu_video/game_show.html.twig', [
            'jeuvideo' => $jeuVideo,
        ]);
    }
}
