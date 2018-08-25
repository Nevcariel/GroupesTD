<?php

namespace App\Controller\Admin;

use App\Entity\Csv;
use App\Form\Admin\CsvType;
use App\Repository\CsvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/csv")
 */
class CsvController extends Controller
{
    /**
     * @Route("/", name="admin_csv_index", methods="GET")
     */
    public function index(CsvRepository $csvRepository): Response
    {
        return $this->render('admin/csv/index.html.twig', ['csvs' => $csvRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_csv_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $csv = new Csv();
        $form = $this->createForm(CsvType::class, $csv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($csv);
            $em->flush();

            return $this->redirectToRoute('admin_csv_index');
        }

        return $this->render('admin/csv/new.html.twig', [
            'csv' => $csv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_csv_show", methods="GET")
     */
    public function show(Csv $csv): Response
    {
        return $this->render('admin/csv/show.html.twig', ['csv' => $csv]);
    }

    /**
     * @Route("/{id}/edit", name="admin_csv_edit", methods="GET|POST")
     */
    public function edit(Request $request, Csv $csv): Response
    {
        $form = $this->createForm(CsvType::class, $csv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('csv_edit', ['id' => $csv->getId()]);
        }

        return $this->render('admin/csv/edit.html.twig', [
            'csv' => $csv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_csv_delete", methods="DELETE")
     */
    public function delete(Request $request, Csv $csv): Response
    {
        if ($this->isCsrfTokenValid('delete'.$csv->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($csv);
            $em->flush();
        }

        return $this->redirectToRoute('admin_csv_index');
    }
}
