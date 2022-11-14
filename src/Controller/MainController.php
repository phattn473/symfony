<?php

namespace App\Controller;

use App\Entity\Curd;
use App\Form\CrudType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(): Response
    {
        $data = $this->getDoctrine()->getRepository(Curd::class)->findAll();

        return $this->render('main/index.html.twig', [
            'list' => $data,
        ]);
    }
    /**
     * @Route("/create", name="create")
     */
    public function Create(Request $request)
    {
        $crud = new Curd();
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDocTrine()->getManager();
            $em->persist($crud);
            $em->flush();

            $this->addFlash('notice','Submitted SucessFully!!');
            return $this->redirectToRoute('main');
        }
        return $this->render('main/create.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/update/{id}", name="update")
     */
    public function Update(Request $request, $id)
    {
        $crud = $this->getDoctrine()->getRepository(Curd::class)->find($id);
        $form = $this->createForm(CrudType::class, $crud);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDocTrine()->getManager();
            $em->persist($crud);
            $em->flush();

            $this->addFlash('notice','Update SucessFully!!');
            return $this->redirectToRoute('main');
        }
        return $this->render('main/update.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function Delete($id)
    {
        $data = $this->getDoctrine()->getRepository(Curd::class)->find($id);
        $em = $this->getDocTrine()->getManager();
        $em->remove($data);
        $em->flush();

        $this->addFlash('notice','Delete SucessFully!!');
        return $this->redirectToRoute('main');
    }
}
