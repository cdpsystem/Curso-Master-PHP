<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Animal;


class AnimalController extends AbstractController
{
    public function index()
    {
		$animalRepo = $this->getDoctrine()->getRepository(Animal::class);
		$animales = $animalRepo->findAll();

		$animal = $animalRepo->findBy([
			'raza' => 'Africana'
		],[
			'id' => 'DESC'
		]);

		var_dump($animal);


		// Query Builder
		$qb = $animalRepo->createQueryBuilder();

        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
            'animales' => $animales,
            'animal' => $animal,

        ]);
    }

    public function save(){
    	$entManager = $this->getDoctrine()->getManager();

    	$animal = new Animal();
    		$animal->setTipo('Avestruz');
    		$animal->setRaza('Africana');
    		$animal->setColor('Verde');

    	// Guardar objeto en doctrine para subir mas tarde
    	$entManager->persist($animal);

    	//Volcar los datos en la tabla
    	$entManager->flush();

    	// Guardar en una tabla de la base de datos
    	return new Response('El animal guardado tiene el id ' . $animal->getId());
    }

    /**
    Lo de abajo hace lo mismo pero es más rapido
    public function animal(int $animal){
    	
    	//Cargar repositorio
    	$animalRepo = $this->getDoctrine()->getRepository(Animal::class);

    	//Consulta
    	$animal = $animalRepo->find($id);
		
    	//Comprobar si el resultado es correcto
    	if(!$animal){
    		$message = "No hay animales con esa ID";
    	}else{
    		$message = "Tu animal elegido es: ".  $animal->getTipo() . " de raza " .  $animal->getRaza() . " y de color " .  $animal->getColor() ;
    	}

    	return new Response($message);
    }
	*/

    public function animal(Animal $animal){
    	if(!$animal){
    		$message = "No hay animales con esa ID";
    	}else{
    		$message = "Tu animal elegido es: ".  $animal->getTipo() . " de raza " .  $animal->getRaza() . " y de color " .  $animal->getColor() ;
    	}

    	return new Response($message);
    }

    public function update($id){
    	// Doctrine
    	$doctrine = $this->getDoctrine();

    	// Entity Manager
    	$em = $doctrine->getManager();

    	// Repo entidad Animal
    	$animalRepo = $em->getRepository(Animal::class);

    	// Find para sacar el objeto
    	$animal = $animalRepo->find($id);

    	// Comprobar si el objeto me llega
    	if(!$animal){
    		$message = 'El animal no existe en la BD';
    	}else{
	    	// Asignarle los valores al objeto
    		$animal->setTipo("Perro $id");
    		$animal->setColor('FuegoAzul');
	    	// Persistir en doctrine el objeto
    		$em->persist($animal);

	    	//Hacer el flush para guardar
    		$em->flush();
    		$message = 'Has actualizado el animal ' . $animal->getId();
    	}

    	//Response
    	return new Response($message);
    }

    public function delete(Animal $animal){
    	var_dump($animal);
    	$em = $this->getDoctrine()->getManager();
    	$message = '';
    	if($animal){
	    	$em->remove($animal);
	    	$em->flush();
	    	$message="Animal borrado correctamente";    		
    	}else{
    		$message="Animal no encontrado";    		
    	}


    	return new Response($message);

    }
}
