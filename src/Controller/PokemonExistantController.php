<?php

namespace App\Controller;

use App\Entity\PokemonExistant;
use App\Form\PokemonExistantType;
use App\Repository\PokemonExistantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/pokemon/existant")
 */
class PokemonExistantController extends AbstractController
{
    /**
     * @Route("/", name="pokemon_existant_index", methods={"GET"})
     */
    public function index(PokemonExistantRepository $pokemonExistantRepository): Response
    {
        return $this->render('pokemon_existant/index.html.twig', [
            'pokemon_existants' => $pokemonExistantRepository->getPokemonByDresseur($this->getUser()->getId()),
        ]);
    }

    /**
     * @Route("/new", name="pokemon_existant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pokemonExistant = new PokemonExistant();
        $form = $this->createForm(PokemonExistantType::class, $pokemonExistant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pokemonExistant);
            $entityManager->flush();

            return $this->redirectToRoute('pokemon_existant_index');
        }

        return $this->render('pokemon_existant/new.html.twig', [
            'pokemon_existant' => $pokemonExistant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pokemon_existant_show", methods={"GET"})
     */
    public function show(PokemonExistant $pokemonExistant): Response
    {
        $error="";
        return $this->render('pokemon_existant/show.html.twig', [
            'pokemon_existant' => $pokemonExistant,
            'error'=>$error
        ]);
    }

    /**
     * @Route("/{id}/entrainer", name="pokemon_existant_entrainement", methods={"GET"})
     */
    public function entrainer(PokemonExistant $pokemonExistant, PokemonExistantRepository $pokemonExistantRepository): Response
    {
       // $courbe=$pokemonExistantRepository->getCourbePokemon($this->getUser()->getId(),$pokemonExistant->getId());
        $diff=$this->checkUneHeureIntervalle($pokemonExistant->getDernierEntrainement());
        //dd($diff);
        if($pokemonExistant->getDernierEntrainement()== null || $diff<=58){
            
            $pokemonExistant->setXp($pokemonExistant->getXp()+random_int ( 10 , 30 ));
           
            $pokemonExistant->setDernierEntrainement(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();


           // $this->gainExperience($courbe,$pokemonExistant);

            $entityManager->persist($pokemonExistant);
            $entityManager->flush();
            $error="";

        }

       else {
            $error="Vous ne pouvez entrainer votre pokemon plus d'une fois par heure!";
        }
        return $this->render('pokemon_existant/show.html.twig', [
            'pokemon_existant' => $pokemonExistant,
            'error'=>$error
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pokemon_existant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PokemonExistant $pokemonExistant): Response
    {
        $form = $this->createForm(PokemonExistantType::class, $pokemonExistant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pokemon_existant_index');
        }

        return $this->render('pokemon_existant/edit.html.twig', [
            'pokemon_existant' => $pokemonExistant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pokemon_existant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PokemonExistant $pokemonExistant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pokemonExistant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pokemonExistant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pokemon_existant_index');
    }

    public function checkUneHeureIntervalle( $heureEntrainement){
        $now = new \DateTime('now');
      
        $diff = $now->diff($heureEntrainement);
        if($diff->y > 0 || $diff->m > 0 || $diff->d > 0 || $diff->h >0){
            return 0;
        }else{
            return (60 - $diff->i);
        }
    }

    public function gainExperience($cbXp,$pokemon){
        

        if($cbXp=="R"){
            $exp=0.8*pow($pokemon->getNiveau(),3);
        }
        elseif($cbXp=="M"){
            $exp=pow($pokemon->getNiveau(),3);
        }
        
        elseif($cbXp=="P"){
            $exp=1.2*pow($pokemon->getNiveau(),3)-15*pow($pokemon->getNiveau(),2)+100*$pokemon->getNiveau()-140;
        }
        else{
            $exp=1.25*pow($pokemon->getNiveau(),3);
        }
        if($exp <= $pokemon->getXp()){
            $pokemon->setNiveau($pokemon->getNiveau()+1);

            $pokemon->setXp($pokemon->getXp()-$exp);
            $this->gainExperience($cbXp,$pokemon);
        }

    }
}
