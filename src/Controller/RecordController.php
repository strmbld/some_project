<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Record;
use App\Form\RecordFormType;
use App\Repository\RecordRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/record")
 */
class RecordController extends AbstractController
{
    /**
     * @Route("/", name="record_index")
     */
    public function index(RecordRepository $recordRepository): Response
    {
        return $this->render('record/index.html.twig', [
            'records' => $recordRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="record_new")
     */
    public function new(Request $request, ImageUploader $imageUploader): Response
    {
        $record = new Record();
        $form = $this->createForm(RecordFormType::class, $record);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form['attachments'][0]['file']->getData()) {
                return new Response('Required image is absent', 400);
            }

            $fileNames = $imageUploader->upload($form);
            foreach ($fileNames as $fileName) {
                $image = (new Image())->setFilename($fileName);
                $record->addImage($image);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($record);
            $entityManager->flush();

            $this->addFlash('success', 'New record added!');

            return $this->redirectToRoute('record_index');
        }

        return $this->renderForm('record/new.html.twig', [
            'form' => $form,
        ]);
    }
}
