<?php

namespace App\Controller\Admin;

use App\Entity\TypeCsv;
use App\Form\TypeCsvType;
use App\Repository\TypeCsvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/type/csv")
 */
class TypeCsvController extends Controller
{
    /**
     * @Route("/", name="admin_type_csv_index", methods="GET")
     */
    public function index(TypeCsvRepository $typeCsvRepository): Response
    {
        return $this->render('admin/type_csv/index.html.twig', ['type_csvs' => $typeCsvRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_type_csv_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $typeCsv = new TypeCsv();
        $form = $this->createForm(TypeCsvType::class, $typeCsv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeCsv);
            $em->flush();

            return $this->redirectToRoute('admin_type_csv_index');
        }

        return $this->render('admin/type_csv/new.html.twig', [
            'type_csv' => $typeCsv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_type_csv_show", methods="GET")
     */
    public function show(TypeCsv $typeCsv): Response
    {
        return $this->render('admin/type_csv/show.html.twig', ['type_csv' => $typeCsv]);
    }

    /**
     * @Route("/{id}/edit", name="admin_type_csv_edit", methods="GET|POST")
     */
    public function edit(Request $request, TypeCsv $typeCsv): Response
    {
        $form = $this->createForm(TypeCsvType::class, $typeCsv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_type_csv_edit', ['id' => $typeCsv->getId()]);
        }

        return $this->render('admin/type_csv/edit.html.twig', [
            'type_csv' => $typeCsv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_type_csv_delete", methods="DELETE")
     */
    public function delete(Request $request, TypeCsv $typeCsv): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeCsv->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeCsv);
            $em->flush();
        }

        return $this->redirectToRoute('admin_type_csv_index');
    }
}
