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
        die('dfdf');
        
        $response = new Response();
        $resultArray = array("test"=>"sono un test");
        $response->setContent(json_encode($resultArray));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
