<?php

namespace App\Controller;

use App\Model\CharacterManager;

class CharacterController extends AbstractController
{
    /**
     * Display character listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     *
     */

    public function index()
    {
        $characterManager = new CharacterManager();
        $characters = $characterManager->selectAll();

        return $this->twig->render("Character/index.html.twig", ['characters' => $characters]);
    }

    /**
     * Display character informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show(int $id)
    {
        $characterManager = new CharacterManager();
        $character = $characterManager->selectOneById($id);

        return $this->twig->render("Character/show.html.twig", ['character' => $character]);
    }

    /**
     * Display character edition page specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id): string
    {
        $characterEdit = new CharacterManager();
        $character = $characterEdit->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $characterEdit->update($_POST);
            header('Location:/Character/edit/' . $_POST['id']);
        }
        return $this->twig->render('Character/edit.html.twig', ['character' => $character]);
    }

    /**
     * Display character creation page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $characterManager = new CharacterManager();
            $character = [
                'name' => $_POST['name'],
                'state' => $_POST['state'],
                'description' => $_POST['description'],
                'picture' => $_POST['picture'],
            ];
            $id = $characterManager->insert($character);
            header('Location:/Character/show/' . $id);
        }

        return $this->twig->render('Character/add.html.twig');
    }


    /**
     * Handle character deletion
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        $characterManager = new CharacterManager();
        $characterManager->delete($id);
        header('Location:/Character/index');
    }

    /**
     * Handle contactmail to admin
     *
     *
     */
    public function about()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $character = [
                'contactName' => $_POST['contactName'],
                'contactEmail' => $_POST['contactEmail'],
                'content' => $_POST['content'],
                'subject' => $_POST['subject'],
            ];
            $sentence = $character['contactName'] . '-from: ' . $character['contactEmail'] . 'message :' .
                $_POST['content'];
            $toDest = 'delphine.belet@gmail.com';
            $subject = 'blog Graveyard -' . $_POST['subject'];
            mail($toDest, $subject, $sentence);
        }
        return $this->twig->render('/Character/about.html.twig');
    }
}
