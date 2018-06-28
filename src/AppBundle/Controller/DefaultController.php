<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use AppBundle\Services\Zip;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\WritePdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DefaultController extends Controller
{

    /**
     * @param Student $student
     * @param WritePdf $writePdf
     * @Route("/generate", name="generate_ecf")
     *
     */
    public function generatePdf(WritePdf $writePdf, Zip $zip){
        $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository(Student::class)->findAll();

        foreach ($students as $student){
            $writePdf->generatePdf($student);
        }
        $writePdf->generatePdf($student);

        $zipInfos = $zip->zipFolder();

        $response = new BinaryFileResponse($zipInfos['path_to_zip']);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $zipInfos['filename']);
        return $response;
    }
}
