<?php

namespace App\Controller;

use App\Repository\ConsoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConsoleController extends AbstractController
{

    /**
     * @Route("/consoles", name="consoles_list")
     */
    public function list(ConsoleRepository $consoleRepository)
    {
        $consoles = $consoleRepository->findAll();

        return $this->render('console/console_list.html.twig', [
            'consoles' => $consoles,
        ]);
    }

    /**
     * @Route("/consoles/{id}/{nom}", name="consoles_show")
     */
    public function show(ConsoleRepository $consoleRepository, $id)
    {
        $console = $consoleRepository->find($id);

        return $this->render('console/console_show.html.twig', [
            'console' => $console,
        ]);
    }


    /**
     * Affichage du menu de la navbar sur toutes les pages
     */
    public function consoleMenu(ConsoleRepository $consoleRepository)
    {
        $consoles = $consoleRepository->findAll();

        return $this->render('_console.html.twig', [
            'consoles' => $consoles,
        ]);
    }


}
