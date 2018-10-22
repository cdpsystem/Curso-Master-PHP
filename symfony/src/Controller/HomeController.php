<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'hello' => 'Hola mundo con symfony 4'
        ]);
    }

    public function animales($nombre,$apellidos)
    {
    	$title = "Bienvenido a la página de animales";
    	return $this->render('home/animales.html.twig',
    		[
    			'title' => $title,
    			'nombre' => $nombre,
    			'apellidos' => $apellidos
    		]
    	);
    }

    public function redirigir()
    {
    	return $this->redirect('https://google.es');

    	//Una forma de redirigir
    	// return $this->redirectToRoute('animales',
    	// 	[
    	// 		'nombre' => 'Jessica',
    	// 		'apellidos' => 'Miguel Candas'
    	// 	]
    	// );
    }

}
