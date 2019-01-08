<?php

namespace App\Controller;

use App\Entity\Wedstrijd;
use App\Form\WedstrijdType;
use App\Repository\WedstrijdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/wedstrijd")
 */
class WedstrijdController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/", name="wedstrijd_index", methods="GET")
     */
    public function index(WedstrijdRepository $wedstrijdRepository): Response
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('wedstrijd/index.html.twig', ['wedstrijds' => $wedstrijdRepository->findAll()]);
        } else {
            return $this->render('other/access.html.twig');
        }
    }

    /**
     * @Route("/new", name="wedstrijd_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('other/access.html.twig');
        }
        $wedstrijd = new Wedstrijd();
        $wedstrijd->setDatumtijd(new \DateTime());
        $form = $this->createForm(WedstrijdType::class, $wedstrijd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($wedstrijd);
            $em->flush();

            return $this->redirectToRoute('wedstrijd_index');
        }

        return $this->render('wedstrijd/new.html.twig', [
            'wedstrijd' => $wedstrijd,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wedstrijd_show", methods="GET")
     */
    public function show(Wedstrijd $wedstrijd): Response
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('other/access.html.twig');
        }
        return $this->render('wedstrijd/show.html.twig', ['wedstrijd' => $wedstrijd]);
    }

    /**
     * @Route("/{id}/edit", name="wedstrijd_edit", methods="GET|POST")
     */
    public function edit(Request $request, Wedstrijd $wedstrijd): Response
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('other/access.html.twig');
        }
        $form = $this->createForm(WedstrijdType::class, $wedstrijd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wedstrijd_edit', ['id' => $wedstrijd->getId()]);
        }

        return $this->render('wedstrijd/edit.html.twig', [
            'wedstrijd' => $wedstrijd,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wedstrijd_delete", methods="DELETE")
     */
    public function delete(Request $request, Wedstrijd $wedstrijd): Response
    {
        if ($this->isCsrfTokenValid('delete' . $wedstrijd->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($wedstrijd);
            $em->flush();
        }

        return $this->redirectToRoute('wedstrijd_index');
    }
}
