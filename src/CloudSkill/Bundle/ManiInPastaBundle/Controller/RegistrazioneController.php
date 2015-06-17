<?php

namespace CloudSkill\Bundle\ManiInPastaBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrazioneController extends Controller
{
    public function registrazioneAction(Request $request, $_format) 
    {
        $user = $request->request->get('user');
        $pass = $request->request->get('password');
        $nome = $request->request->get('nome');
        $cognome = $request->request->get('cognome');
        $requiredParameters = array("nome","cognome","user","password");
        $receivedParameters = $request->request->keys();
        
        $intersectParams = array_intersect($requiredParameters, $receivedParameters);
        if (!count($intersectParams)) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400,'You need to specify at least one of ' . implode(',', $requiredParameters));
        }
        
        
        
//    | test     | letmein   | test@knplabs.com      |active|
//    | inactive | letmein   | inactive@symfony.com  |inactive|
//    | disable  | letmein   | disavle@symfony.com   |disable|
            
        
        
        
        if($user == "disable"  and $pass=="letmein"){
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(403,"Forbidden User Disable");
        }        
        
        if($user == "inactive"  and $pass=="letmein"){
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(403,"Forbidden User Disable");
        }    
        $response = new Response();
        $resultArray = array(
            "user"=>$user,
            "nome"=>$nome,
            "cognome"=>$cognome,
            "status"=>"inactive");
        $response->setContent(json_encode($resultArray));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
            
        
    }

}
