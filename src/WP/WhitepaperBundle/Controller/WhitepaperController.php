<?php

namespace WP\WhitepaperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use WP\WhitepaperBundle\Entity\Whitepaper;
use WP\WhitepaperBundle\Entity\File;
use WP\WhitepaperBundle\Entity\Image;
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
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistr??e.');
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
            $request->getSession()->getFlashBag()->add('notice', 'Livre blanc bien modifi??.');
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
            $request->getSession()->getFlashBag()->add('info', "Le livre blanc a bien ??t?? supprim??.");
            return $this->redirect($this->generateUrl('wp_whitepaper_homepage'));
        }

        return $this->render('WPWhitepaperBundle:Whitepaper:delete.html.twig', array(
            'whitepaper' => $whitepaper,
            'form'   => $form->createView()
        ));

    }

    public function searchAction($query) {

        /*
        $type = $this->get('fos_elastica.index.elasticsearch');

        $query_part = new \Elastica\Query\Bool();
        $query_part->addShould(
            new \Elastica\Query\Term(array('title' => array('value' => $query, 'boost' => 3)))
        );
        $query_part->addShould(
            new \Elastica\Query\Term(array('description' => array('value' => $query)))
        );

        $filters = new \Elastica\Filter\Bool();
//        $filters->addMust(
//            new \Elastica\Filter\Term(array('language' => 'fr'))
//        );
//        $filters->addMust(
//            new \Elastica\Filter\NumericRange('published_at', array(
//                'lte' => date('c'),
//            ))
//        );

        $query = new \Elastica\Query\Filtered($query_part, $filters);

        $results = $type->search($query);

        $whitepapers = $results->getResults();
        $facets = $results->getFacets();
        $hits = $results->getTotalHits();
        print_r($results);*/


//        $repositoryManager = $this->container->get('fos_elastica.manager');
//        $repository = $repositoryManager->getRepository('WPWhitepaperBundle:Whitepaper');
//        $results = $repository->find('mon');

//        print_r($results);

        return $this->render('WPWhitepaperBundle:Whitepaper:search.html.twig',
            array('query' => $query, 'whitepapers' => $results));

    }

    public function testAction() {

        $text = 'Contenu de mon message.';
        $subject = 'Mon sujet';
        $to = 'anthony.destenay@gmail.com';

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom( $this->container->getParameter('mailer_from') )
            ->setTo($to)
            ->setBody($this->renderView('WPWhitepaperBundle:Whitepaper:email.txt.twig', array('text' => $text)))
        ;
        $this->get('mailer')->send($message);

        return $this->render('WPWhitepaperBundle:Whitepaper:test.html.twig'
        );
    }
}
