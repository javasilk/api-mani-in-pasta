<?php

namespace CloudSkill\Bundle\ManiInPastaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CloudSkillManiInPastaBundle:Default:index.html.twig', array('name' => $name));
    }
}
