<?php

namespace WP\WhitepaperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use WP\WhitepaperBundle\Entity\Editor;
use WP\WhitepaperBundle\Form\EditorType;
use WP\WhitepaperBundle\Form\EditorEditType;

class EditorController extends Controller
{

    public function indexAction($page)
    {

        if(!isset($page) or empty($page)) { $page = 1; }

        if ($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }

        $nbPerPage = 10;

        $listEditors = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('WPWhitepaperBundle:Editor')
            ->getEditors($page, $nbPerPage)
        ;

        $nbPages = ceil(count($listEditors)/$nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        return $this->render('WPWhitepaperBundle:Editor:index.html.twig', array(
            'listEditors' => $listEditors,
            'nbPages'     => $nbPages,
            'page'        => $page
        ));

    }

//    public function viewAction($id)
//    {
//
//        $em = $this->getDoctrine()->getManager();
//
//        $whitepaper = $em
//            ->getRepository('WPWhitepaperBundle:Whitepaper')
//            ->find($id)
//        ;
//
//        if (null === $whitepaper) {
//            throw new NotFoundHttpException("Ce livre blanc n'existe pas...");
//        }
//
//        return $this->render('WPWhitepaperBundle:Whitepaper:view.html.twig', array(
//            'whitepaper'    => $whitepaper
//        ));
//    }

    public function addAction(Request $request)
    {

        $editor = new Editor();

        $form = $this->createForm(new EditorType(), $editor);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($editor);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Editeur bien enregistré.');
            return $this->redirect($this->generateUrl('wp_editor_view', array('id' => $editor->getId())));
        }

        return $this->render('WPWhitepaperBundle:Editor:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $editor = $em->getRepository('WPWhitepaperBundle:Editor')->find($id);

        if (null === $editor) {
            throw new NotFoundHttpException("L'éditeur avec l'id ".$id." n'existe pas.");
        }

        $form = $this->createForm(new EditorEditType, $editor);

        if ($form->handleRequest($request)->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'L\'Éditeur a bien modifié.');
            return $this->redirect($this->generateUrl('wp_editor_homepage'));
        }

        return $this->render('WPWhitepaperBundle:Editor:edit.html.twig', array(
            'editor' => $editor,
            'form' => $form->createView()
        ));

    }

//    public function deleteAction($id, Request $request)
//    {
//
//        $em = $this->getDoctrine()->getManager();
//        $whitepaper = $em->getRepository('WPWhitepaperBundle:Whitepaper')->find($id);
//        if (null === $whitepaper) {
//            throw new NotFoundHttpException("Le livre blanc avec l'id ".$id." n'existe pas.");
//        }
//        $form = $this->createFormBuilder()->getForm();
//        if ($form->handleRequest($request)->isValid()) {
//            $em->remove($whitepaper);
//            $em->flush();
//            $request->getSession()->getFlashBag()->add('info', "Le livre blanc a bien été supprimé.");
//            return $this->redirect($this->generateUrl('wp_whitepaper_homepage'));
//        }
//
//        return $this->render('WPWhitepaperBundle:Whitepaper:delete.html.twig', array(
//            'whitepaper' => $whitepaper,
//            'form'   => $form->createView()
//        ));
//
//    }
}
