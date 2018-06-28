<?php

namespace AppBundle\Services;

use AppBundle\Entity\Student;
use setasign\Fpdi\Fpdi;

class WritePdf
{
    private $template_directory;

    public function __construct($template_directory)
    {
        $this->template_directory = $template_directory;
    }

    public function generatePdf(Student $student){
        // initiate FPDI
        $pdf = new Fpdi();
        // set the source file
        $pdf->setSourceFile($this->template_directory . "php.pdf");
        // import page 1
        $tplIdx = $pdf->importPage(1);
        $size = $pdf->getTemplateSize($tplIdx);
        $pdf->AddPage('P');

        // use the imported page and place it at position 10,10 with a width of 100 mm
        $pdf->useTemplate($tplIdx);

        // now write some text above the imported page
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetTextColor(0, 0, 0);


        // Write Name
        $pdf->SetXY(75.5, 194);
        $pdf->Write(0, $student->getName());

        // Write Firstnqme
        $pdf->SetXY(75.5, 200);
        $pdf->Write(0, $student->getFirstname());

        // Write DateBirth
        $pdf->SetXY(75.5, 206);
        $pdf->Write(0, $student->getDateOfBirth()->format('d-m-Y'));

        $pdf->Output();
    }

}
