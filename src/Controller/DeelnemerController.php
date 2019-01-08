<?php

namespace App\Controller;

use App\Entity\Deelnemer;
use App\Form\DeelnemerType;
use App\Repository\DeelnemerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/deelnemer")
 */
class DeelnemerController extends AbstractController
{
    /**
     * @Route("/", name="deelnemer_index", methods="GET")
     */
    public function index(DeelnemerRepository $deelnemerRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App:Categorie')->findAll();
        foreach ($categories as $categorie) {
            $count[] = count($deelnemerRepository->findBy(['categorieid' => $categorie]));
        }
        return $this->render('deelnemer/index.html.twig', ['deelnemers' => $deelnemerRepository->findAll(),
                                                                 'categories' => $categories,
                                                                 'counts' => $count,
        ]);
    }

    /**
     * @Route("/show/{search}", name="deelnemer_search", methods="GET")
     */
    public function IndexShow(DeelnemerRepository $deelnemerRepository, $search): Response
    {
        return $this->render('deelnemer/indexshow.html.twig', ['deelnemers' => $deelnemerRepository->findBySearchField($search)]);
    }

    /**
     * @Route("/new", name="deelnemer_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $deelnemer = new Deelnemer();
        $form = $this->createForm(DeelnemerType::class, $deelnemer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($deelnemer);
            $em->flush();

            return $this->redirectToRoute('deelnemer_index');
        }

        return $this->render('deelnemer/new.html.twig', [
            'deelnemer' => $deelnemer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="deelnemer_show", methods="GET")
     */
    public function show(Deelnemer $deelnemer): Response
    {
        return $this->render('deelnemer/show.html.twig', ['deelnemer' => $deelnemer]);
    }

    /**
     * @Route("/{id}/edit", name="deelnemer_edit", methods="GET|POST")
     */
    public function edit(Request $request, Deelnemer $deelnemer): Response
    {
        $form = $this->createForm(DeelnemerType::class, $deelnemer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('deelnemer_edit', ['id' => $deelnemer->getId()]);
        }

        return $this->render('deelnemer/edit.html.twig', [
            'deelnemer' => $deelnemer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="deelnemer_delete", methods="DELETE")
     */
    public function delete(Request $request, Deelnemer $deelnemer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deelnemer->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($deelnemer);
            $em->flush();
        }

        return $this->redirectToRoute('deelnemer_index');
    }
}
