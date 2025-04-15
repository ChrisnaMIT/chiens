<?php

namespace App\Controller;

use App\Entity\Chiens;
use App\Repository\ChiensRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class ChiensController extends AbstractController
{
    #[Route('/chiens', name: 'app_chiens')]
    public function index(ChiensRepository $chiensRepository): Response
    {
        $chiens = $chiensRepository->findAll();

        return $this->render('chiens/index.html.twig', [
            'chiens' => $chiens
        ]);
    }

    #[Route ('/chiens/{id}', name: 'app_chiens_show')]
        public function show(Chiens $chien,): Response
    {
        return $this ->render('chiens/show.html.twig', [
            'chien' => $chien
        ]);
    }


    #[Route ('/chiens/{id}/delete', name: 'app_chiens_delete')]
        public function delete(Request $request, Chiens $chien, EntityManagerInterface $em): Response
    {

        if($this->isCsrfTokenValid('delete'.$chien->getId(), $request->request->get('_token'))){
            $em->remove($chien);
            $em->flush();
        }

        return $this->redirectToRoute('app_chiens');


    }


}
