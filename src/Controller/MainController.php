<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\EntityRepository;
use App\Repository\PokemonExistantRepository;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @isGranted("ROLE_USER")
     */
    public function index(EntityRepository $entityRepository,PokemonExistantRepository $repo)
    {
        $nb = $repo->countPokemonExistantByIdDresseur($this->getUser()->getId());
        
        $nbEvo = $repo->getEvolutionByDresseur($this->getUser()->getId());
        $stats = $repo->getStatsByTypePokemonExistant($this->getUser()->getId());
        return $this->render('main/index.html.twig', [
            //'pokemons' => $pokemons,
            'nb' => $nb,
            'stats' => $stats,
            'nbEvo' => $nbEvo
        ]);
    }
}
