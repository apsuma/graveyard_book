<?php


namespace App\Controller;

use App\Model\CategoryManager;

class CategoryController extends AbstractController
{
    public function show()
    {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->selectAll();

        return $this->twig->render("Category/show.html.twig", ["categories" => $categories]);
    }
}
