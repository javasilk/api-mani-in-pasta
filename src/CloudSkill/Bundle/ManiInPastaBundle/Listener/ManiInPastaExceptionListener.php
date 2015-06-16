<?php

namespace CloudSkill\Bundle\ManiInPastaBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Monolog\Logger as Logger;

class ManiInPastaExceptionListener {

    /** @var $logger Logger */
    protected $logger;

    public function onKernelException(GetResponseForExceptionEvent $event) {

        $exception = $event->getException();
        /* @var $logger Logger */
        $logger = $this->logger;

        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;

        $request = $event->getRequest();

        $trace['error']['route'] = $request->get('_route');
        $trace['error']['line'] = $exception->getLine();
        $trace['error']['file'] = $exception->getFile();
        $trace['error']['trace'] = $exception->getTraceAsString();

        $content=array();
        if ($statusCode == 500) {
            $content['error'] = array(
                "code" => $statusCode,
                "message" => $exception->getMessage(),
                "line" => $exception->getLine(),
                //"trace" => $exception->getTraceAsString()
            );
        } else {
            $content['error'] = array(
                "code" => $statusCode,
                "message" => $exception->getMessage()
            );
        }

        $trace['response'] = $content;
        $logger->error("Exception caught by ExceptionListener, error: ", $trace);


        $response = new Response();
        $response->setStatusCode($statusCode);
        $response->headers->set('Content-Type', 'application/json');
        $jsonContent=json_encode($content);
        
        //EM 20141216: FIX exception for bad encoded json
        if(json_last_error()!=JSON_ERROR_NONE){
            $jsonContent="['error converting to json: ". json_last_error_msg()."']";
        }
        $response->setContent(json_encode($content));

        $event->setResponse($response);
    }

    public function setLogger($logger) {
        $this->logger = $logger;
    }

}

?>
