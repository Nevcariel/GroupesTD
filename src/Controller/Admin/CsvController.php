<?php

namespace App\Controller\Admin;

use App\Entity\Csv;
use App\Entity\Promotion;
use App\Form\Admin\CsvType;
use App\Repository\CsvRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CsvReader;
use App\Service\FileUploader;

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
     * @Route("/new/import/{id}", name="admin_csv_new_import", methods="GET|POST")
     */
    public function newImport(Promotion $promotion, Request $request, FileUploader $fileUploader): Response
    {
        /*$csv = new Csv();
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
        ]);*/
        $entityManager = $this->getDoctrine()->getManager();

        $csv = new Csv();
        $form = $this->createForm(CsvType::class, $csv);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $file = $csv->getFile();
            $fileName = $fileUploader->Upload($file);
            $csv->setFile($fileName);
            $csv->setPromotion($promotion);
            $csv->setName($promotion->getAnneeDebut()."/".$promotion->getAnneeFin());
            $entityManager->persist($csv);

            $entityManager->flush();

            return $this->redirectToRoute('admin_import_csv', array(
                'id' => $csv->getId(),
            ));
        }

        return $this->render('admin/csv/new.html.twig', array(
            
            'form' => $form->CreateView(),
        ));
    }
    /**
     * @Route("/new/update/{id}", name="admin_csv_new_update", methods="GET|POST")
     */
    public function newUpdate(Promotion $promotion, Request $request, FileUploader $fileUploader): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $csv = new Csv();
        $form = $this->createForm(CsvType::class, $csv);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $file = $csv->getFile();
            $fileName = $fileUploader->Upload($file);
            $csv->setFile($fileName);
            $csv->setPromotion($promotion);
            $csv->setName($promotion->getAnneeDebut()."/".$promotion->getAnneeFin());
            $entityManager->persist($csv);

            $entityManager->flush();

            return $this->redirectToRoute('admin_update_csv', array(
                'id' => $csv->getId(),
            ));
        }

        return $this->render('admin/csv/new.html.twig', array(
            
            'form' => $form->CreateView(),
        ));
    }

    /**
    * @Route("/import/{id}", name="admin_import_csv")
    */
    public function importCsv(Csv $csv, Request $request, CsvReader $csvReader)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $csvReader->importDataFromCsv($csv, $entityManager);

        return $this->redirectToRoute('admin_etudiant_index', array(
        ));
    }

    /**
    * @Route("/update/{id}", name="admin_update_csv")
    */
    public function updateCsv(Csv $csv, Request $request, CsvReader $csvReader)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $csvReader->updateDataFromCsv($csv, $entityManager);

        return $this->redirectToRoute('admin_etudiant_index', array(
        ));
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
