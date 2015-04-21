<?php

namespace DWES\farmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use DWES\farmanagerBundle\Entity\Usuario;
use DWES\farmanagerBundle\Form\UsuarioType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\HttpFoundation\Response;




class UsuarioController extends Controller
{
    public function registroAction($id)
    {
        $sesione = $this->get('request')->getSession();

        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $params['id'] = $id;

        if ($id === -1)
            $usuario = new Usuario();
        else
        {
            $usuario = $em->getRepository('DWESfarmanagerBundle:Usuario')
                ->find($id);
            if(!$usuario)
            {
                throw $this->createNotFoundException(
                    'No existe nigun usuario con id '.$id);
            }
        }

        $form = $this->createForm(new UsuarioType(), $usuario);

        if ($this->getRequest()->isMethod('POST'))
        {

            $form->bind($this->getRequest());
            if ($form->isValid())
            {

                $usuario->setRol('ROLE_REGISTRADO');

                //PASSWORD ENCODER
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($usuario);
                // Evidentemente, nuestro password vendrá de un formulario
                $password = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());
                $usuario->setPassword($password);

                $em->persist($usuario);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    ' Ya estás registrado <strong>como: '.$usuario->getUsername().'</strong> ahora puedes entrar.'
                );

                return $this->redirect($this->generateUrl('dwes_blog_login'));
            }
            else
            {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    'Error, revise los campos del formulario'
                );
                $this->redirect($this->generateUrl("dwes_blog_registro"));
            }

        }
        return $this->render('DWESfarmanagerBundle:Default:registro.html.twig',array(
            'form' => $form->createView()
        ));
    }

    public function perfilAction($username)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('DWESfarmanagerBundle:Usuario')->findOneByUsername($username);

        if(!$usuario)
        {
            throw $this->createNotFoundException(
                'No existe nigún perfil con el usuario: '.$username);
        }

        $params = array(
            'usuario' => $usuario,
        );

        return $this->render('DWESfarmanagerBundle:Default:perfil.html.twig',$params);
    }

    public function eliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comentario = $em->getRepository('DWESfarmanagerBundle:Usuario')->find($id);
        $em->remove($comentario);
        $em->flush();

        $this->get('session')->getFlashBag()->add('error', 'Usuario <strong>Eliminado correctamente</strong>');

        return $this->redirect($this->generateUrl("dwes_blog_logout"));
    }
}