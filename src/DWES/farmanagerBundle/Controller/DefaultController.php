<?php

namespace DWES\farmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use DWES\farmanagerBundle\Entity\Usuario;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use DWES\farmanagerBundle\Entity\Entrada;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entradas = $em->getRepository('DWESfarmanagerBundle:Entrada')->findBy(array(), array('id' => 'DESC'));

        $params = array(
            'entradas' => $entradas,
        );

        return $this->render('DWESfarmanagerBundle:Default:index.html.twig', $params);
    }
}
