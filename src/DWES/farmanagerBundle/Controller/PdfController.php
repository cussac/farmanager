<?php

namespace DWES\farmanagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DWES\farmanagerBundle\Entity\Comentario;
use Symfony\Component\HttpFoundation\Request;


class PdfController extends Controller
{
    public function pdfAction()
    {
        $html = $this->renderView('DWESfarmanagerBundle:Default:pdf.html.twig'
        );

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