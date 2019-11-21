<?php

namespace App\Controller;

use App\Model\CharacterManager;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

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
            date_default_timezone_set('Etc/UTC');
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'localhost';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'delphine.belet@gmail.com';                     // SMTP username
                $mail->Password   = 'secret';                               // SMTP password
                $mail->Port       = 465;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('delphine.belet@gmail.com', 'Mailer');
                $mail->addAddress('delphine.belet@gmail.com', 'User');     // Add a recipient

                // Content
                $mail->isHTML(false);                                  // Set email format to HTML
                $mail->Subject =  $_POST['subject'];
                $mail->Body    = <<<EOT
Email: {$_POST['contactEmail']}
Name: {$_POST['contactName']}
Message: {$_POST['content']}
EOT;
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        return $this->twig->render('/Character/about.html.twig');
    }
}
