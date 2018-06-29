<?php

namespace AppBundle\Services;

use AppBundle\Entity\Student;
use setasign\Fpdi\Fpdi;

/**
 * Class WritePdf
 * @package AppBundle\Services
 */
class WritePdf
{
    /**
     * @var
     */
    private $template_directory;
    /**
     * @var
     */
    private $output;

    /**
     * WritePdf constructor.
     * @param $template_directory
     * @param $output
     */
    public function __construct($template_directory, $output)
    {
        $this->template_directory = $template_directory;
        $this->output = $output;
    }

    /**
     * @param Student $student
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
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
        $pdf->SetFont('Helvetica','', 10);

        // Generate page 1
        $this->setCampus($pdf, $student->getPromo()->getCity()->getName());
        $this->setName($pdf, $student->getName());
        $this->setFirstname($pdf, $student->getFirstname());
        $this->setDateBirth($pdf, $student->getDateOfBirth());
        $this->setGender($pdf, $student->getGender());

        $filename = $student->getName() . '_' . $student->getFirstname() . '_ecf.pdf';
        if (!file_exists($this->output . str_replace(' ', '_', $student->getPromo()->getName()))) {
            mkdir($this->output . str_replace(' ', '_', $student->getPromo()->getName()), 0777, true);
        }
        $pdf->Output('F', $this->output . str_replace(' ', '_', $student->getPromo()->getName()) . '/' . $filename);
    }

    /**
     * @param Fpdi $pdf
     * @param $name
     */
    private function setName(Fpdi $pdf, $name){
        $pdf->SetXY(75.5, 194);
        $pdf->Write(0, $name);
    }

    /**
     * @param Fpdi $pdf
     * @param $firstname
     */
    private function setFirstname(Fpdi $pdf, $firstname){
        $pdf->SetXY(75.5, 200);
        $pdf->Write(0, $firstname);
    }

    /**
     * @param Fpdi $pdf
     * @param \DateTime $date
     */
    private function setDateBirth(Fpdi $pdf, \DateTime $date){
        $pdf->SetXY(75.5, 206);
        $pdf->Write(0, $date->format('d-m-Y'));
    }

    /**
     * @param Fpdi $pdf
     * @param $campus
     */
    private function setCampus(Fpdi $pdf, $campus){
        $pdf->SetXY(75.5, 176);
        $pdf->Write(0, $campus);
    }

    /**
     * @param Fpdi $pdf
     * @param $gender
     */
    private function setGender(Fpdi $pdf, $gender){
        if ($gender == Student::FEMALE){
            $pdf->SetXY(90, 188.8);
        } elseif ($gender == Student::MALE){
            $pdf->SetXY(110, 188.8);
        }
        $check = "4";
        $pdf->SetFont('ZapfDingbats','', 10);
        $pdf->Cell(0, 0, $check, 0, 0);
    }
}
