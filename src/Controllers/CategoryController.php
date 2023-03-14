<?php

namespace App\Controllers;

use App\Http\Contracts\MustAuthenticate;
use App\Http\Response\Response as JsonResponse;
use App\Models\Category;
use App\Models\Video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[MustAuthenticate]
class CategoryController extends AbstractController{

    public function __construct(
        private EntityManagerInterface $entityManager
    ){}
    
    public function index(Request $request): Response {

        $page = $request->get("page", 1);
        
        $categoryRepository = $this->entityManager->getRepository(Category::class);

        $categories = $categoryRepository->findAllPaginated($page);

        if(!$categories){
            throw new \DomainException('No categories found', Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($categories);
    }

    public function show(int $id): Response {

        $categoryRepository = $this->entityManager->getRepository(Category::class);

        $category = $categoryRepository->find($id);

        if(!$category){
            throw new \DomainException('Category not found', Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($category);
    }

    public function store(Request $request): Response {

        $requestData = json_decode($request->getContent(), true);

        if(!$requestData){
            throw new \DomainException('Invalid request', Response::HTTP_BAD_REQUEST);
        }

        $category = new Category();
        $category->setTitle($requestData['title']);
        $category->setColor($requestData['color']);
        $category->setCreatedAt(new \DateTime());

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return new JsonResponse($category, Response::HTTP_CREATED);

    }

    public function update(Request $request, int $id): Response {
        $categoryRepository = $this->entityManager->getRepository(Category::class);

        $category = $categoryRepository->find($id);

        if(!$category){
            throw new \DomainException('Category not found', Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        if(!$requestData){
            throw new \DomainException('Invalid request', Response::HTTP_BAD_REQUEST);
        }

        foreach ($requestData as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (method_exists($category, $setter)) {
                 
                $category->{$setter}($value);   
            }
        }

        $category->setTitle($requestData['title']);
        $category->setColor($requestData['color']);
        $category->setUpdatedAt(new \DateTime());

        $this->entityManager->flush();

        return new JsonResponse($category);
    }

    public function destroy(int $id): Response {
        $categoryRepository = $this->entityManager->getRepository(Category::class);

        $category = $categoryRepository->find($id);

        if(!$category){
            throw new \DomainException('Category not found', Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return new JsonResponse(
            data: ['message' => 'Category deleted successfully'],
            json: false
        );
    }

    public function getVideosByCategory(Request $request, int $id): Response {

        $page = $request->get("page", 1);

        $categoryRepository = $this->entityManager->getRepository(Category::class);

        $category = $categoryRepository->find($id);

        if(!$category){
            throw new \DomainException('Category not found', Response::HTTP_NOT_FOUND);
        }

        $videoRepository = $this->entityManager->getRepository(Video::class);

        $videos = $videoRepository->findByCategoryPaginated($category, $page);

        if(!$videos){
            throw new \DomainException('No videos found', Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($videos);

    }
}