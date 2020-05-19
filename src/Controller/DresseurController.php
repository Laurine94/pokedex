<?php

namespace App\Controller;

use App\Entity\Dresseur;
use App\Form\DresseurType;
use App\Entity\PokemonExistant;
use App\Repository\DresseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityRepository;


/**
 * @Route("/dresseur")
 */
class DresseurController extends AbstractController
{

     /**
     *
     * @var UserPasswordEncoderInterface
     */

   private $encoder;
 
   public function __construct(UserPasswordEncoderInterface $encoder)
   {
       $this->encoder=$encoder;
   }

    /**
     * @Route("/", name="dresseur_index", methods={"GET"})
     */
    public function index(DresseurRepository $dresseurRepository): Response
    {
        return $this->render('dresseur/index.html.twig', [
            'dresseurs' => $dresseurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dresseur_new", methods={"GET","POST"})
     */
    public function new(Request $request ): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dresseur = new Dresseur();
        $form = $this->createForm(DresseurType::class, $dresseur,[
            'entity_manager' => $entityManager,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager = $this->getDoctrine()->getManager();
            $dresseur->setRoles(['ROLE_USER']);
            $dresseur->setPieces(5000);
            $pass=$request->get("pass");
            //dd($pass);
            $dresseur->setPassword($this->encoder->encodePassword($dresseur, $pass));
            //dd($dresseur);
            $entityManager->persist($dresseur);
            $entityManager->flush();

           $starter=new PokemonExistant($dresseur->getStarter(),$dresseur);
           $entityManager->persist($starter);
           $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('dresseur/new.html.twig', [
            'dresseur' => $dresseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dresseur_show", methods={"GET"})
     */
    public function show(Dresseur $dresseur): Response
    {
        return $this->render('dresseur/show.html.twig', [
            'dresseur' => $dresseur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dresseur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dresseur $dresseur): Response
    {
        $form = $this->createForm(DresseurType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dresseur_index');
        }

        return $this->render('dresseur/edit.html.twig', [
            'dresseur' => $dresseur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dresseur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dresseur $dresseur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dresseur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dresseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dresseur_index');
    }
}
