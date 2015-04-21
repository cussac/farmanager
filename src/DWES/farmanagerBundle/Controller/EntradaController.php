<?php

namespace DWES\farmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use DWES\farmanagerBundle\Entity\Usuario;
use DWES\farmanagerBundle\Form\EntradaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use DWES\farmanagerBundle\Entity\Entrada;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;




class EntradaController extends Controller
{
    public function listarAction()
    {
        $userLogin = $this->getUser();
        $sesion = $this->getRequest()->getSession();
        $sesion->set('usuario_id',$userLogin->getId());
        $em = $this->getDoctrine()->getManager();

        if(in_array("ROLE_REGISTRADO",$userLogin->getRoles()))
        {
            $entradas = $userLogin->getEntradas();
        }
        else
        {
            $entradas = $em->getRepository("DWESfarmanagerBundle:Entrada")->findAll();
        }

        $params = array('entradas' => $entradas);

        return $this->render('DWESfarmanagerBundle:Default:listar.html.twig',$params);
    }

    public function formularioAction($id)
    {
        $sesione = $this->get('request')->getSession();

        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $params['id'] = $id;

        if ($id === -1)
            $entrada = new Entrada();
        else
        {
            $entrada = $em->getRepository('DWESfarmanagerBundle:Entrada')
                ->find($id);
            if(!$entrada)
            {
                throw $this->createNotFoundException(
                    'No existe niguna entrada con id '.$id);
            }
        }

        $form = $this->createForm(new EntradaType(), $entrada);

        if ($this->getRequest()->isMethod('POST'))
        {
            $form->bind($this->getRequest());
            if ($form->isValid())
            {
                $usuarioId = $this->getUser();
                $usuario = $em->getRepository("DWESfarmanagerBundle:Usuario")->find($usuarioId);

                $entrada->setUsuario($usuario);

                $em->persist($entrada);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Entrada creada correctamente');
                return $this->redirect($this->generateUrl('dwes_admin_Index'));

            }

        }
        return $this->render('DWESfarmanagerBundle:Default:entrada.html.twig',
            array('form' => $form->createView(), 'id' => $id));
    }

    public function verAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entrada = $em->getRepository('DWESfarmanagerBundle:Entrada')->find($id);

        if(!$entrada)
        {
            throw $this->createNotFoundException(
                'No existe nigúna entrada con id '.$id);
        }

        $params = array(
            'entrada' => $entrada,
        );

        return $this->render('DWESfarmanagerBundle:Default:ver.html.twig',$params);
    }

    public function eliminarEntradasAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entradas = $em->getRepository('DWESfarmanagerBundle:Entrada')->find($id);
        $em->remove($entradas);
        $em->flush();

        $this->get('session')->getFlashBag()->add('error', 'Entrada <strong>Eliminada correctamente</strong>');

        $userLogin = $this->getUser();
        $sesion = $this->getRequest()->getSession();
        $sesion->set('usuario_id',$userLogin->getId());
        $em = $this->getDoctrine()->getManager();

        if(in_array("ROLE_REGISTRADO",$userLogin->getRoles()))
        {
            $entradas = $userLogin->getEntradas();
        }
        else
        {
            $entradas = $em->getRepository("DWESfarmanagerBundle:Entrada")->findAll();
        }

        $params = array('entradas' => $entradas);

        return $this->render('DWESfarmanagerBundle:Default:listar.html.twig',$params);
    }

}