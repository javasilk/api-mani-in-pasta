<?php

namespace CloudSkill\Bundle\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CloudSkill\Bundle\ManiInPastaBundle\Entity\ManiInPasta\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CloudSkillTestBundle:Default:index.html.twig', array('name' => $name));
    }
    
    
    public function userCreateAction(Request $request)
    {
        $username = $request->request->get('user');
        $pass = $request->request->get('password');
        $nome = $request->request->get('nome');
        $cognome = $request->request->get('cognome');
        $status = $request->request->get('status');
        $token = $request->request->get('token');
        
        
        $user = new CloudSkill\Bundle\ManiInPastaBundle\Entity\ManiInPasta\User();
        $user->setNome($nome);
        $user->setCognome($cognome);
        $user->setUser($username);
        $user->setStatus($status);
        $user->setPassword($pass);
        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();
        $array = array("id"=>$user->getId());
        return new Response(json_encode($array));        
        
    }
    
}







