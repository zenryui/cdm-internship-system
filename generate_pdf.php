<?php

use Dompdf\Dompdf;

require_once 'dompdf/autoload.inc.php';

$dompdf = new Dompdf();

$HTML="<img src='-1218210879.png.jpg'>"."Image Issue in 1.0.2 in Dompdf";

$dompdf->loadHtml($HTML);

$dompdf->setPaper('A', 'landscape');

$dompdf->render();

$dompdf->stream();