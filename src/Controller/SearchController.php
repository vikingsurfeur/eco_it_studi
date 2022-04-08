<?php

namespace App\Controller;

use App\Form\SearchCourseType;
use App\Repository\CourseRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(
        CourseRepository $courseRepository,
        TagRepository $tagRepository,
        Request $request
    ): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('app_login');
        }

        $searchCourseForm = $this->createForm(SearchCourseType::class);
        $searchCourseForm->handleRequest($request);

        if($searchCourseForm->isSubmitted() && $searchCourseForm->isValid()) {
            $search = $searchCourseForm->get('search')->getData();
            $tag = $tagRepository->findBy(['name' => $search]);

            empty($tag) ?
                $courses = null :
                $courses = $courseRepository->findByTag($tag[0]);
        } 

        return $this->render('search/index.html.twig', [
            'search_form' => $searchCourseForm->createView(),
            'courses' => $courses ?? null,
        ]);
    }
}
