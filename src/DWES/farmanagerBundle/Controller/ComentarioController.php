<?php

namespace DWES\farmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DWES\farmanagerBundle\Entity\Comentario;
use Symfony\Component\HttpFoundation\Request;


class ComentarioController extends Controller
{
    public function comentarioAction($id)
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();

        $identrada = $em->getRepository('DWESfarmanagerBundle:Entrada')->find($id);
        $usuarioId = $this->getUser();


        if($usuarioId == NULL )
        {
            $usuario = $em->getRepository("DWESfarmanagerBundle:Usuario")->find($usuarioId = 2);
        }
        else
        {
            $usuario = $em->getRepository("DWESfarmanagerBundle:Usuario")->find($usuarioId);
        }

        $comentario = new Comentario();

        $comentario->setEntrada($identrada);
        $comentario->setUsuario($usuario);

        $form = $this->createFormBuilder($comentario)
            ->add('titulo','text', array(
                    'attr'=>array(
                        'class'=>'form-control input-lg',
                    ))
            )
            ->add('contenido', 'textarea', array(
                    'attr'=>array(
                        'class'=>'form-control',
                        'placeholder' => '140 caracteres máximo'
                    ))
            )
            ->getForm();

        if ($request->server->get('REQUEST_METHOD') == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {

                $em->persist($comentario);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Comentario añadido correctamente');
                return $this->redirect($this->generateUrl('dwes_blog_homepage'));
            }
        }

        $params['entrada'] = $identrada;
        $params['titulo'] = '';
        $params['contenido'] = '';
        $params['usuario'] = $usuario;
        $params['form'] = $form->createView();

        return $this->render(
            'DWESfarmanagerBundle:Default:comentario.html.twig',
            $params);

    }

    public function listarAction($id)
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

        return $this->render('DWESfarmanagerBundle:Default:listarComentario.html.twig',$params);
    }

    public function eliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $comentario = $em->getRepository('DWESfarmanagerBundle:Comentario')->find($id);

        if(!$comentario)
        {
            throw $this->createNotFoundException(
                'No existe nigúna entrada con id '.$id);
        }

        $em->remove($comentario);
        $em->flush();

        $this->get('session')->getFlashBag()->add('error', 'Comentario <strong>Eliminado correctamente</strong>');

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

    public function eliminarComentariosAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comentario = $em->getRepository('DWESfarmanagerBundle:Comentario')->find($id);
        $em->remove($comentario);
        $em->flush();

        $this->get('session')->getFlashBag()->add('error', 'Comentario <strong>Eliminado correctamente</strong>');

        $userLogin = $this->getUser();
        $sesion = $this->getRequest()->getSession();
        $sesion->set('usuario_id',$userLogin->getId());
        $em = $this->getDoctrine()->getManager();

        if(in_array("ROLE_REGISTRADO",$userLogin->getRoles()))
        {
            $comentarios = $userLogin->getEntradas();
        }
        else
        {
            $comentarios = $em->getRepository("DWESfarmanagerBundle:Comentario")->findAll();
        }

        $params = array('comentarios' => $comentarios);

        return $this->render('DWESfarmanagerBundle:Default:listarComentarioUsuario.html.twig',$params);
    }

    public function listarUsuarioAction()
    {
        $userLogin = $this->getUser();
        $sesion = $this->getRequest()->getSession();
        $sesion->set('usuario_id',$userLogin->getId());
        $em = $this->getDoctrine()->getManager();

        if(in_array("ROLE_REGISTRADO",$userLogin->getRoles()))
        {
            $comentarios = $userLogin->getEntradas();
        }
        else
        {
            $comentarios = $em->getRepository("DWESfarmanagerBundle:Comentario")->findAll();
        }

        $params = array('comentarios' => $comentarios);

        return $this->render('DWESfarmanagerBundle:Default:listarComentarioUsuario.html.twig',$params);
    }


}
