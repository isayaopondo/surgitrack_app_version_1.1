<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function pdf_create($html, $filename = '', $stream = TRUE) {

    require_once APPPATH . '/third_party/dompdf/autoload.inc.php';

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    //$dompdf->stream();
   
      if ($stream) {
      $dompdf->stream($filename . ".pdf");
      } else {
      return $dompdf->output();
      } 
}
