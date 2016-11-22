<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of MainController
 *
 * @author Rafał Niewiński
 */
class MainController extends Controller {
   
    
    public function homepageAction()
    {
        return $this->render('main/homepage.html.twig');
    }
}
