<?php

namespace CloudSkill\Bundle\ManiInPastaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Exception\Exception;

class LoginController extends Controller {

    public function loginAction(Request $request, $_format) {
        try{
            $response = new Response();
            $response->setContent(json_encode(array()));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } catch (Exception $e) {
            throw new HttpException(500, "Generic server errror: " . $e->getMessage());
        }
    }

}
