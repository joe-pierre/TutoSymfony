<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipes', name: 'app_recipes')]
    public function index(Request $request): Response
    {
        return $this->render('recipe/index.html.twig');
    }

    #[Route(
        '/recipe/{slug}-{id}', 
        name: 'app_recipe_show', 
        requirements: [
            'slug' => '[a-z0-9^-]+',
            'id' => '[0-9]+',
        ],
    )]
    public function show(Request $request): Response
    {
        return $this->render('recipe/show.html.twig', compact('slug', 'id'));
    }
}
