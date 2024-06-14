<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once("./application/third_party/dompdf/autoload.inc.php");

use Dompdf\Dompdf;

class Pdf
{
    public function generate($html, $filename = '', $stream = TRUE, $paper = 'A4', $orientation = "portrait")
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);

        // options
        $options = $dompdf->getOptions(); 
        $options->set(
            array(
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
            )
        );
        $dompdf->setOptions($options);

        // $context = stream_context_create([ 
        //     'ssl' => [ 
        //         'verify_peer' => FALSE, 
        //         'verify_peer_name' => FALSE,
        //         'allow_self_signed'=> TRUE 
        //     ] 
        // ]);
        // $dompdf->setHttpContext($context);
        
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
        } else {
            $output = $dompdf->output();
            return $output;
        }
    }
}
