<?php


namespace AppBundle\Controller;

use AppBundle\Service\MarkDownTransformer;
use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class GenusController extends Controller {
    
    /**
     *@Route("/genus/new",  name="")
     */
     public function newAction()
     {
         $genus = new Genus(); 
         $genus->setName('Octopus' .rand(1, 100 ));
         $genus->setSpeciesCount(rand(100, 99999));
         $genus->setSubFamily('Octopodinae');
         
        
        $note = new GenusNote();
        $note->setUsername('AquaWeaver');
        $note->setUserAvatarFilename('ryan.jpeg');
        $note->setNote('I counted 8 legs... as they wrapped around me');
        $note->setCreatedAt(new \DateTime('-1 month'));
         
         
         
         $em = $this->getDoctrine()->getManager();
         $em->persist($genus);
         $em->persist($note);
         $em->flush();
         
         return new Response('<html><body>Genus created!</body></html>');
    }
    
    /**
     * 
     * 
     * @Route("/genus")
     */
    public function listAction()
    {
     $em = $this->getDoctrine()->getManager();
     $genuses = $em->getRepository('AppBundle\Entity\Genus')
        ->findAllPublishedOrderByRecentlyAcitive();
     
     
     
     return $this->render('genus/list.html.twig' , [
               'genuses' => $genuses
             ]);
    }
    
    
    
    /**
     *  @Route("/genus/{genusname}", name="genus_show")
     */
    public function showAction($genusname)
    {
        $note= "terololo"    ; 
        
        $em = $this->getDoctrine()->getManager();
        $genus = $em->getRepository('AppBundle:Genus')
             ->findOneBy(['name' => $genusname]);
        
        
        if(!$genus)
        {
            throw $this->createNotFoundException('No genus Found');
        } 
        $funFact = 'Octopusty to bardzo bystre bestie i trzeba bardzo na nie uważać bo moga zagryść swojego pana *moc*';
        
        $transformer = $this->get('app.markdown_transformer');
        
        $funFact = $transformer->parse($genus->getFunFact());
         
      
        
     
        $recentNotes = $em->getRepository('AppBundle:GenusNote')
                ->findAllRecentNotesForGenus($genus);
        
        $templating = $this->container->get('templating');
        $html = $templating->render('genus/show.html.twig', array(  
          'genus' => $genus,
          'funFact' => $funFact,
          'recentNoteCount' => count($recentNotes)
                ));
        return new Response($html);    
    }
    
    /**
     * @Route("/genus/{name}/notes", name="genus_show_notes")
     * @Method("GET")
     */
    public function getNotesAction(Genus $genus)
    {       
            $notes= [];
            
            foreach($genus->getNotes() as $note )
            {
              $notes[] = [
                'id' => $note->getId(),
                'username' => $note->getUsername(),
                'avatarUri' => '/images/'.$note->getUserAvatarFilename(),
                'note' => $note->getNote(),
                'date' => $note->getCreatedAt()->format('M d, Y')
               ];
            }
    $data = [
      'notes' => $notes
      ];
     return new JsonResponse($data);
    }
    
}
