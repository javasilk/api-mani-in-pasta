<?php

namespace CloudSkill\Bundle\ManiInPastaBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    public function loginAction(Request $request, $_format) 
    {
        $user = $request->request->get('user');
        $pass = $request->request->get('pass');
        
        if(empty($user)){
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400,"Bad User");
        }
        
        if(empty($pass)){
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400,"Bad pass");
        }
        
        if($user == "test"  and $pass=="letmin"){
            $response = new Response();
            $resultArray = array("username"=>$username,"userid"=>"123","fullname"=>"utente test");
            $response->setContent(json_encode($resultArray));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
            
        }else {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(404,"User Not Found");
        }
        
    }

}
