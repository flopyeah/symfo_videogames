<?php

namespace App\Controller;

use App\Entity\Console;
use App\Entity\JeuVideo;
use App\Form\ConsoleType;
use App\Form\JeuVideoType;
use App\Repository\ConsoleRepository;
use App\Repository\JeuVideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/admin.html.twig', [
        ]);
    }

    /**
     * @Route("/admin/console", name="admin_console")
     */
    public function console(ConsoleRepository $consoleRepository)
    {
        $consoles = $consoleRepository->findAll();

        return $this->render('admin/console.html.twig', [
            'consoles' => $consoles,
        ]);
    }

    /**
     * @Route("/admin/game", name="admin_game")
     */
    public function game(JeuVideoRepository $jeuVideoRepository)
    {
        $jeuVideos = $jeuVideoRepository->findAll();

        return $this->render('admin/game.html.twig', [
            'jeuVideos' => $jeuVideos,
        ]);
    }

    /**
     * @Route("/admin/game/add", name="admin_game_add")
     * @Route("/admin/game/edit/{id}", name="admin_game_modify")
     */
    public function gameForm(Request $request, EntityManagerInterface $entityManager, JeuVideoRepository $jeuVideoRepository, $id = null) {

        if ($id !== null ) {
            $jeuvideo = $jeuVideoRepository->find($id);
        }
        else {
            $jeuvideo = new JeuVideo();
        }


        // je genere le formulaire Annonce
        $form = $this->createForm(JeuVideoType::class, $jeuvideo);

        // je recupere les données du form
        $form->handleRequest($request);

        // si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {

            // je procede a l'enregistrement de mes données
            //$jeuvideo->setCreatedAt( new \DateTime);

            $entityManager->persist($jeuvideo);

            // j'enregistre les données en BDD
            $entityManager->flush();

            // j'ajoute un message flash pour alerter le user
            $this->addFlash(
                'ajout',
                'Votre Jeu video a bien été ajouté'
            );

            // je redirige vers la page de l'annonce
            return $this->redirectToRoute('games_show', [
                'id' => $jeuvideo->getId()
            ]);
        }

        return $this->render('admin/game_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/console/add", name="admin_console_add")
     * @Route("/admin/console/edit/{id}", name="admin_console_modify")
     */
    public function consoleForm (Request $request, EntityManagerInterface $entityManager, ConsoleRepository $consoleRepository, $id = null){

        if ($id !== null ) {
            $console = $consoleRepository->find($id);
        }
        else {
            $console = new Console();
        }

        // je genere le formulaire Annonce
        $form = $this->createForm(ConsoleType::class, $console);

        // je recupere les données du form
        $form->handleRequest($request);

        // si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {

            // je procede a l'enregistrement de mes données
            $entityManager->persist($console);

            // j'enregistre les données en BDD
            $entityManager->flush();

            // j'ajoute un message flash pour alerter le user
            $this->addFlash(
                'ajout',
                'Votre Jeu video a bien été ajouté'
            );

            // je redirige vers la page de l'annonce
            return $this->redirectToRoute('consoles_show', [
                'id' => $console->getId()
            ]);
        }

        return $this->render('admin/console_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/console/delete/{id}", name="admin_console_delete", methods={"DELETE"})
     */
    public function delete_console(Request $request,  Console $console)
    {
        if ($this->isCsrfTokenValid('delete'.$console->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($console);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_console');
    }

    /**
     * @Route("/admin/game/delete/{id}", name="admin_game_delete", methods={"DELETE"})
     */
    public function delete_game(Request $request, JeuVideo $jeuVideo)
    {
        if ($this->isCsrfTokenValid('delete'.$jeuVideo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jeuVideo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_game');
    }

}
