<?php

namespace CloudSkill\Bundle\ManiInPastaBundle\Controller;

use CloudSkill\Bundle\ManiInPastaBundle\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Exception\Exception;

class RegistrazioneController extends Controller {

    public function registrazioneAction(Request $request, $_format) {
//        $user = $request->request->get('user');
//        $pass = $request->request->get('password');
//        $nome = $request->request->get('nome');
//        $cognome = $request->request->get('cognome');
//        $requiredParameters = array("nome","cognome","user","password");
//        $receivedParameters = $request->request->keys();
//        
//        $intersectParams = array_intersect($requiredParameters, $receivedParameters);
//        if (!count($intersectParams)) {
//            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400,'You need to specify at least one of ' . implode(',', $requiredParameters));
//        }


        $username = $request->request->get('username');
        $pass = $request->request->get('password');
        $nome = $request->request->get('nome');
        $cognome = $request->request->get('cognome');
        $email = $request->request->get('email');
        $status = 'inactive';
        $token = md5($pass . microtime(true));
        $tokenDeltaSec = 60 * 60 * 24; //1 giorno

        $timestamp = time();
        $tokenExpTs = $timestamp + $tokenDeltaSec;
        $dateTokenExp = new DateTime();
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
        return new Response(json_encode($user->toArray()));

//        
//        $response = new Response();
//        $resultArray = array(
//            "user"=>$user,
//            "nome"=>$nome,
//            "cognome"=>$cognome,
//            "status"=>"inactive");
//        $response->setContent(json_encode($resultArray));
//        $response->headers->set('Content-Type', 'application/json');
//        return $response;
    }

    public function activateAction(Request $request, $username) {
        $token = $request->query->get('token');
        if (empty($token)) {
            throw new \Symfony\Component\HttpKernel\Exception\HttpException(400, "Bad request: token cannot be void");
        }
        try {
            $userRepo = $this->getDoctrine()->getRepository('CloudSkillManiInPastaBundle:User');
            /* @var $user User */
            $user = $userRepo->findOneBy(array('username' => $username, 'token' => $token));
            if ($user == null) {
                throw new HttpException(403, "Forbidden");
            }
            if (!$user->getStatus() or $user->getStatus() != "inactive") {
                throw new HttpException(403, "Forbidden: user not inactive");
            }
             $nowDate=new \Datetime();
             \Symfony\Component\VarDumper\VarDumper::dump($user->getTokenExp()->getTimestamp());
             \Symfony\Component\VarDumper\VarDumper::dump($nowDate->getTimestamp());
            if ($user->getTokenExp()->getTimestamp() < $nowDate->getTimestamp()) {
                throw new HttpException(403, "Forbidden: token expired." . $user->getTokenExp()->getTimestamp() . "---" . $nowDate->getTimestamp());
            }

            $user->setStatus('active');
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $response = new Response();
            $user->toArray();
            $response->setContent(json_encode($user->toArray()));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } catch (Exception $e) {
            throw new HttpException(500, "Generic server errror: " . $e->getMessage());
        }
    }

}
