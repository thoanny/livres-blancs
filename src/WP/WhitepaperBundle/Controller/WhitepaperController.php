<?php

namespace WP\WhitepaperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use WP\WhitepaperBundle\Entity\Whitepaper;
use WP\WhitepaperBundle\Form\WhitepaperType;
use WP\WhitepaperBundle\Form\WhitepaperEditType;

class WhitepaperController extends Controller
{

    public function menuAction($limit = 3)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('WPWhitepaperBundle:Whitepaper')
        ;

        $listWhitepapers = $repository->findBy(
            array('published' => true),
            array('updatedAt' => 'desc', 'id' => 'desc'),
            $limit,
            0
        );
        return $this->render('WPWhitepaperBundle:Whitepaper:menu.html.twig', array(
            'listWhitepapers' => $listWhitepapers
        ));
    }

    public function indexAction($page)
    {

        if(!isset($page) or empty($page)) { $page = 1; }

        if ($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }

        $nbPerPage = 10;

        $listWhitepapers = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('WPWhitepaperBundle:Whitepaper')
            ->getWhitepapers($page, $nbPerPage)
        ;

        $nbPages = ceil(count($listWhitepapers)/$nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        return $this->render('WPWhitepaperBundle:Whitepaper:index.html.twig', array(
            'listWhitepapers' => $listWhitepapers,
            'nbPages'     => $nbPages,
            'page'        => $page
        ));

    }

    public function viewAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $whitepaper = $em
            ->getRepository('WPWhitepaperBundle:Whitepaper')
            ->find($id)
        ;

        if (null === $whitepaper) {
            throw new NotFoundHttpException("Ce livre blanc n'existe pas...");
        }

        return $this->render('WPWhitepaperBundle:Whitepaper:view.html.twig', array(
            'whitepaper'    => $whitepaper
        ));
    }

    public function addAction(Request $request)
    {

        $whitepaper = new Whitepaper();

        $form = $this->createForm(new WhitepaperType(), $whitepaper);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($whitepaper);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            return $this->redirect($this->generateUrl('wp_whitepaper_view', array('id' => $whitepaper->getId())));
        }

        return $this->render('WPWhitepaperBundle:Whitepaper:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $whitepaper = $em->getRepository('WPWhitepaperBundle:Whitepaper')->find($id);

        if (null === $whitepaper) {
            throw new NotFoundHttpException("Le livre blanc avec l'id ".$id." n'existe pas.");
        }

        $form = $this->createForm(new WhitepaperEditType, $whitepaper);

        if ($form->handleRequest($request)->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Livre blanc bien modifié.');
            return $this->redirect($this->generateUrl('wp_whitepaper_view', array('id' => $whitepaper->getId())));
        }

        return $this->render('WPWhitepaperBundle:Whitepaper:edit.html.twig', array(
            'whitepaper' => $whitepaper,
            'form' => $form->createView()
        ));

    }

    public function deleteAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $whitepaper = $em->getRepository('WPWhitepaperBundle:Whitepaper')->find($id);
        if (null === $whitepaper) {
            throw new NotFoundHttpException("Le livre blanc avec l'id ".$id." n'existe pas.");
        }
        $form = $this->createFormBuilder()->getForm();
        if ($form->handleRequest($request)->isValid()) {
            $em->remove($whitepaper);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "Le livre blanc a bien été supprimé.");
            return $this->redirect($this->generateUrl('wp_whitepaper_homepage'));
        }

        return $this->render('WPWhitepaperBundle:Whitepaper:delete.html.twig', array(
            'whitepaper' => $whitepaper,
            'form'   => $form->createView()
        ));

    }
}
