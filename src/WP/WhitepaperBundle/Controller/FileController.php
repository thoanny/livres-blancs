<?php

namespace WP\WhitepaperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use WP\WhitepaperBundle\Entity\File;

class FileController extends Controller
{

    public function downloadAction($slug, $token)
    {
        /*
         * @TODO
         * - Vérifier si le visiteur est connecté
         * - Enregistrer le téléchargement dans les stats
         */

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('WPWhitepaperBundle:File')
        ;

        $file = $repository->findOneByToken($token);

        $basePath = __DIR__.'/../../../../web/uploads/documents';


        $filePath = $basePath.'/'.$file->getId().'.'.$file->getPath();

        // check if file exists
        if (!file_exists($filePath)) {
            throw $this->createNotFoundException();
        }

        $filename = $slug.'.'.$file->getPath();

        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename,
            iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
        );

        return $response;

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
    }


}
