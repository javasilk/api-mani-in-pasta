<?php

namespace CloudSkill\Bundle\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CloudSkill\Bundle\ManiInPastaBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    public function indexAction($name) {
        return $this->render('CloudSkillTestBundle:Default:index.html.twig', array('name' => $name));
    }

    

    public function userCreateAction(Request $request) {
        $username = $request->request->get('username');
        $pass = $request->request->get('password');
        $nome = $request->request->get('nome');
        $cognome = $request->request->get('cognome');
        $email = $request->request->get('email');
        $status = $request->request->get('status');
        $token = $request->request->get('token');
        $tokenDeltaSec = $request->request->get('token_expire_delta_sec');

        $timestamp = time();
        $tokenExpTs = $timestamp + $tokenDeltaSec;
        $dateTokenExp = new \DateTime();
        $dateTokenExp->setTimestamp($tokenExpTs);




        $user = new User();
        $user->setUserName($username);
        $user->setPassword(sha1($pass));
        $user->setNome($nome);
        $user->setCognome($cognome);
        $user->setEmail($email);
        $user->setStatus($status);
        $user->setToken($token);
        $user->setTokenExp($dateTokenExp);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();
        $array = array("id" => $user->getId());
        return new Response(json_encode($array));
    }

    public function userDeleteAction(Request $request) {
        $q = $request->query->get('q');
        if ($q == "all") {
            $userRepo = $this->getDoctrine()->getRepository('CloudSkillManiInPastaBundle:User');
            $count=$userRepo->deleteAll();
        }
        return new Response("Deleted users: " . $count);
    }
    
    
    public function getTokenDetailsAction(Request $request,$username){
         $userRepo = $this->getDoctrine()->getRepository('CloudSkillManiInPastaBundle:User');
            /* @var $user User */
            $user = $userRepo->findOneBy(array('username' => $username));
            $resultArray=array('token'=>$user->getToken(),'token_exp'=>$user->getTokenExp(),'username'=>$user->getUsername());
            return new Response(json_encode($resultArray));
        
    }

}
