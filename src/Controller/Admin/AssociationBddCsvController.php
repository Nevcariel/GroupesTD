<?php

namespace App\Controller\Admin;

use App\Entity\AssociationBddCsv;
use App\Form\Admin\AssociationBddCsvType;
use App\Repository\AssociationBddCsvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/association/bdd/csv")
 */
class AssociationBddCsvController extends Controller
{
    /**
     * @Route("/", name="admin_association_bdd_csv_index", methods="GET")
     */
    public function index(AssociationBddCsvRepository $associationBddCsvRepository): Response
    {
        return $this->render('admin/association_bdd_csv/index.html.twig', ['association_bdd_csvs' => $associationBddCsvRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_association_bdd_csv_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $associationBddCsv = new AssociationBddCsv();
        $form = $this->createForm(AssociationBddCsvType::class, $associationBddCsv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($associationBddCsv);
            $em->flush();

            return $this->redirectToRoute('admin_association_bdd_csv_index');
        }

        return $this->render('admin/association_bdd_csv/new.html.twig', [
            'association_bdd_csv' => $associationBddCsv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_association_bdd_csv_show", methods="GET")
     */
    public function show(AssociationBddCsv $associationBddCsv): Response
    {
        return $this->render('admin/association_bdd_csv/show.html.twig', ['association_bdd_csv' => $associationBddCsv]);
    }

    /**
     * @Route("/{id}/edit", name="admin_association_bdd_csv_edit", methods="GET|POST")
     */
    public function edit(Request $request, AssociationBddCsv $associationBddCsv): Response
    {
        $form = $this->createForm(AssociationBddCsvType::class, $associationBddCsv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_association_bdd_csv_edit', ['id' => $associationBddCsv->getId()]);
        }

        return $this->render('admin/association_bdd_csv/edit.html.twig', [
            'association_bdd_csv' => $associationBddCsv,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_association_bdd_csv_delete", methods="DELETE")
     */
    public function delete(Request $request, AssociationBddCsv $associationBddCsv): Response
    {
        if ($this->isCsrfTokenValid('delete'.$associationBddCsv->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($associationBddCsv);
            $em->flush();
        }

        return $this->redirectToRoute('admin_association_bdd_csv_index');
    }
}
