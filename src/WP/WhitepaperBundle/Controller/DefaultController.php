<?php

namespace WP\WhitepaperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WPWhitepaperBundle:Default:index.html.twig', array('name' => $name));
    }
}
