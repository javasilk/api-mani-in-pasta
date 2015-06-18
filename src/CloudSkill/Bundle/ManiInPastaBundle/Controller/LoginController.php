<?php

namespace CloudSkill\Bundle\ManiInPastaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Exception\Exception;

class LoginController extends Controller {

    public function loginAction(Request $request, $_format) {
        $username = $request->request->get('username');
        $pass = $request->request->get('password');
        if (empty($username)) {
            throw new HttpException(400, "Bad User");
        }

        if (empty($pass)) {
            throw new HttpException(400, "Bad pass");
        }

        try {
            $userRepo = $this->getDoctrine()->getRepository('CloudSkillManiInPastaBundle:User');
            /* @var $user User */
            $user = $userRepo->findOneBy(array('username' => $username, 'password'=>sha1($pass)));

            if ($user == null) {
                throw new HttpException(403, "Forbidden");
            }
            if (!$user->getStatus() or $user->getStatus() != "active") {
                throw new HttpException(403, "Forbidden: user not active");
            }

            $response = new Response();
            $user->toArray();
            $response->setContent(json_encode($user->toArray()));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } catch (Exception $e) {
            throw new HttpException(500, "Generic server errror: " . $e->getMessage());
        }
//        if(empty($user)){
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400,"Bad User");
//        }
//        
//        if(empty($pass)){
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400,"Bad pass");
//        }
//        
//        if($user == "disable"  and $pass=="letmein"){
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(403,"Forbidden User Disable");
//        }        
//        
//        if($user == "inactive"  and $pass=="letmein"){
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(403,"Forbidden User Disable");
//        }    
//        
//        if($user == "test"  and $pass=="sbagliata"){
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(403,"User not found");
//        }    
//        if($user == "cippalippa"  and $pass=="sbagliata"){
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(403,"User not found");
//        }    
//        
//        
//        
//        
//        if($user == "test"  and $pass=="letmein"){
//            $response = new Response();
//            $resultArray = array("username"=>$username,"userid"=>"123","fullname"=>"utente test");
//            $response->setContent(json_encode($resultArray));
//            $response->headers->set('Content-Type', 'application/json');
//            return $response;
//            
//        }else {
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(404,"User Not Found ".$user.": ".$pass);
//        }
    }

}
