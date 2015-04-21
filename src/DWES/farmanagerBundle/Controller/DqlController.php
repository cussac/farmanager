<?php

namespace DWES\blogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DqlController extends Controller
{
    public function buscarAction()
    {
        $params = array(
            'nombre' => '',
            'resultado' => array()
        );

        $request = $this->getRequest();
        if ($request->server->get('REQUEST_METHOD') == 'POST')
        {
            $em = $this->getDoctrine()->getManager();
            $dql = "SELECT ent FROM DWESblogBundle:Entrada ent where ";

            if ($request->request->get('nombre') !== null
                && $request->request->get('nombre') !== '')
            {
                $params['nombre'] = $request->request->get('nombre');
                $parametros_busqueda['nombre'] = $request->request->get('nombre');
                $dql .= "ent.titulo LIKE :param_nombre or ent.entrada LIKE :param_nombre" ;
            }

            if ($params['nombre'] !== '')
            {
                $query = $em->createQuery($dql);
                $query->setParameter('param_nombre','%'.$params['nombre'].'%');
                $params['resultado'] = $query->getResult();
            }
        }

        return $this->render('DWESblogBundle:Default:buscar.html.twig', $params);
    }

    public function filtroAction()
    {
        $params = array(
            'titulo' => '',
            'resultado' => array()
        );

        $request = $this->getRequest();
        if ($request->server->get('REQUEST_METHOD') == 'POST')
        {
            $em = $this->getDoctrine()->getManager();
            $dql = "SELECT ent FROM DWESblogBundle:Entrada ent where ";

            if ($request->request->get('titulo') !== null
                && $request->request->get('titulo') !== '')
            {
                $params['titulo'] = $request->request->get('titulo');
                $parametros_busqueda['titulo'] = $request->request->get('titulo');
                $dql .= "ent.titulo LIKE :param_titulo" ;
            }

            if ($params['titulo'] !== '')
            {
                $query = $em->createQuery($dql);
                $query->setParameter('param_titulo','%'.$params['titulo'].'%');
                $params['resultado'] = $query->getResult();
            }
        }

        return $this->render('DWESblogBundle:Default:filtro.html.twig', $params);
    }

}