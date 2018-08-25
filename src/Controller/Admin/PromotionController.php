<?php

namespace App\Controller\Admin;

use App\Entity\Promotion;
use App\Form\Admin\PromotionType;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/promotion")
 */
class PromotionController extends Controller
{
    /**
     * @Route("/", name="admin_promotion_index", methods="GET")
     */
    public function index(PromotionRepository $promotionRepository): Response
    {
        return $this->render('admin/promotion/index.html.twig', ['promotions' => $promotionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_promotion_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();

            return $this->redirectToRoute('admin_promotion_index');
        }

        return $this->render('admin/promotion/new.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_promotion_show", methods="GET")
     */
    public function show(Promotion $promotion): Response
    {
        return $this->render('admin/promotion/show.html.twig', ['promotion' => $promotion]);
    }

    /**
     * @Route("/{id}/edit", name="admin_promotion_edit", methods="GET|POST")
     */
    public function edit(Request $request, Promotion $promotion): Response
    {
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_promotion_edit', ['id' => $promotion]);
        }

        return $this->render('admin/promotion/edit.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_promotion_delete", methods="DELETE")
     */
    public function delete(Request $request, Promotion $promotion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promotion->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($promotion);
            $em->flush();
        }

        return $this->redirectToRoute('admin_promotion_index');
    }

    /**
     * @Route("/import", name="admin_promotion_import", methods="GET|POST")
     */
    public function import(Request $request): Response
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();

            return $this->redirectToRoute('admin_csv_upload', [
                'promotion' => $promotion,
            ]);
        }

        return $this->render('admin/promotion/new.html.twig', [
            'promotion' => $promotion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_promotion_update", methods="GET|POST")
     */
    public function update(Request $request, Promotion $promotion): Response
    {
        
        return $this->redirectToRoute('admin_csv_upload', [
            'promotion' => $promotion,
        ]);
    }

}
