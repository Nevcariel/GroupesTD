<?php

namespace App\Controller\Admin;

use App\Entity\ChampCsv;
use App\Form\ChampCsvType;
use App\Repository\ChampCsvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/champ/csv")
 */
class ChampCsvController extends Controller
{
    /**
     * @Route("/", name="admin_champ_csv_index", methods="GET")
     */
    public function index(ChampCsvRepository $champCsvRepository): Response
    {
        return $this->render('admin/champ_csv/index.html.twig', ['champ_csvs' => $champCsvRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_champ_csv_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $champCsv = new ChampCsv();
        $form = $this->createForm(ChampCsvType::class, $champCsv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($champCsv);
            $em->flush();

            return $this->redirectToRoute('admin_champ_csv_index');
        }

        return $this->render('admin/champ_csv/new.html.twig', [
            'champ_csv' => $champCsv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_champ_csv_show", methods="GET")
     */
    public function show(ChampCsv $champCsv): Response
    {
        return $this->render('champ_csv/show.html.twig', ['champ_csv' => $champCsv]);
    }

    /**
     * @Route("/{id}/edit", name="admin_champ_csv_edit", methods="GET|POST")
     */
    public function edit(Request $request, ChampCsv $champCsv): Response
    {
        $form = $this->createForm(ChampCsvType::class, $champCsv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_champ_csv_edit', ['id' => $champCsv->getId()]);
        }

        return $this->render('admin/champ_csv/edit.html.twig', [
            'champ_csv' => $champCsv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_champ_csv_delete", methods="DELETE")
     */
    public function delete(Request $request, ChampCsv $champCsv): Response
    {
        if ($this->isCsrfTokenValid('delete'.$champCsv->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($champCsv);
            $em->flush();
        }

        return $this->redirectToRoute('admin_champ_csv_index');
    }
}
