<?php

namespace CloudSkill\Bundle\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CloudSkillTestBundle:Default:index.html.twig', array('name' => $name));
    }
}
