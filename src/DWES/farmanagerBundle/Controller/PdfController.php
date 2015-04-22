<?php

namespace DWES\farmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DWES\farmanagerBundle\Entity\Comentario;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class PdfController extends Controller
{
    public function pdfAction($id)
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

        $html = $this->renderView('DWESfarmanagerBundle:Default:pdf.html.twig'
                ,$params);

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="fichero.pdf"'
            )
        );

    }
}