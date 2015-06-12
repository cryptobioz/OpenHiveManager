<?php

namespace KG\BeekeepingManagementBundle\Controller;

use KG\BeekeepingManagementBundle\Entity\Rucher;
use KG\BeekeepingManagementBundle\Form\RucherType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RucherController extends Controller
{
    public function indexAction($page)
    {
        if ($page < 1){
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
        }
        
        $maxRuchers     = $this->container->getParameter('max_ruchers_per_page');
        $ruchers_count  = $this->getDoctrine()->getRepository('KGBeekeepingManagementBundle:Rucher')->getNbRucherTotal();
        
        $pagination = array(
            'page'         => $page,
            'route'        => 'kg_beekeeping_management_homepage_rucher',
            'pages_count'  => ceil($ruchers_count / $maxRuchers),
            'route_params' => array()
        );
        
        $ruchers = $this->getDoctrine()->getRepository('KGBeekeepingManagementBundle:Rucher')->getList($page, $maxRuchers);
        
        return $this->render('KGBeekeepingManagementBundle:Rucher:index.html.twig', 
                            array(  
                                 'ruchers'      => $ruchers,
                                 'nbRuchers'    => $ruchers_count,
                                 'pagination'   => $pagination
                            )
        ); 
    }
    
    public function viewAction($id)
    {
        return $this->render('KGBeekeepingManagementBundle:Rucher:view.html.twig', array('id' => $id));
    }
    
    public function addAction(Request $request)
    {
        $rucher = new Rucher();
        $form = $this->get('form.factory')->create(new RucherType, $rucher);
        
        if ($form->handleRequest($request)->isValid()){
                        
            $em = $this->getDoctrine()->getManager();
            $em->persist($rucher);
            $em->flush();
        
        $request->getSession()->getFlashBag()->add('notice','Rucher créé avec succès');
        
            return $this->redirect($this->generateUrl('kg_beekeeping_management_homepage_rucher', array('id' => $rucher->getId())));
        }

        return $this->render('KGBeekeepingManagementBundle:Rucher:add.html.twig', array('form' => $form->createView()));
    } 
}