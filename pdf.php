<?php
include("Wkhtmltopdf.php");
    try {
        //$wkhtmltopdf = new Wkhtmltopdf(array('path' => APPLICATION_PATH . '/../public/uploads/'));
        $wkhtmltopdf = new Wkhtmltopdf(array('path' => 'pdf'));
        $wkhtmltopdf->setTitle("Title");
        $wkhtmltopdf->setHtml("pages/moniteurs.php");
        $wkhtmltopdf->output(Wkhtmltopdf::MODE_EMBEDDED, "file.pdf");
    } catch (Exception $e) {
        echo $e->getMessage();
    }



?>