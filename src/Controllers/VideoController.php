<?php 

namespace App\Controllers;

use App\Http\Contracts\FreeToRequest;
use App\Http\Contracts\MustAuthenticate;
use App\Http\Response\Response as JsonResponse;
use App\Models\Category;
use App\Models\Video;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[MustAuthenticate]
class VideoController extends AbstractController{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index(Request $request) : Response
    {
        $title = $request->get("search");
        $page = $request->get("page", 1);

        $videoRepository = $this->entityManager->getRepository(Video::class);

        $videos = $videoRepository->findByTitlePaginated($title, $page);

        if(!$videos){
            throw new DomainException('No videos found', Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($videos);
    }

    public function show(int $id) : Response
    {
        $videoRepository = $this->entityManager->getRepository(Video::class);

        $video = $videoRepository->find($id);

        if(!$video){
            throw new DomainException('Video not found', Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($video);
    }

    public function store(Request $request) : Response
    {

        $requestData = json_decode($request->getContent(), true);

        if(!$requestData){
            throw new DomainException('Invalid request', Response::HTTP_BAD_REQUEST);
        }

        $categoryRepository = $this->entityManager->getRepository(Category::class);

        if(!empty($requestData['category_id'])){

            $category = $categoryRepository->find($requestData['category_id']);
        }
        else{
            $category = $categoryRepository->find(1);
        }

        if(!$category){
            throw new DomainException('Category not found', Response::HTTP_NOT_FOUND);
        }

        $video = new Video();

        $video->setTitle($requestData['title'] ?? '');
        $video->setUrl($requestData['url'] ?? '');
        $video->setDescription($requestData['description'] ?? '');
        $video->setCategory($category);
        $video->setCreatedAt(new \DateTime());

        $this->entityManager->persist($video);
        $this->entityManager->flush();

        return new JsonResponse($video);
    }

    public function update(int $id, Request $request) : Response
    {
        $videoRepository = $this->entityManager->getRepository(Video::class);

        $video = $videoRepository->find($id);

        if(!$video){
            throw new DomainException('Video not found test', Response::HTTP_NOT_FOUND);
        }

        $requestData = json_decode($request->getContent(), true);

        if(!$requestData){
            throw new DomainException('Invalid request', Response::HTTP_BAD_REQUEST);
        }

        foreach ($requestData as $property => $value) {
            $setter = 'set' . ucfirst($property);
            if (method_exists($video, $setter)) {
                 
                $video->{$setter}($value);   
            }
        }

        $video->setUpdatedAt(new \DateTime());

        $this->entityManager->flush();

        return new JsonResponse($video);
    }

    public function destroy(int $id) : Response
    {
        $videoRepository = $this->entityManager->getRepository(Video::class);

        $video = $videoRepository->find($id);

        if(!$video){
            throw new DomainException('Video not found test 2', Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($video);
        $this->entityManager->flush();

        return new JsonResponse(
            data: ['message' => 'Video deleted successfully'],
            json: false
        );
    }

    #[FreeToRequest]
    public function freeVideos() : Response
    {

        $videoRepository = $this->entityManager->getRepository(Video::class);

        $videos = $videoRepository->findBy(["id" => [1, 2, 3]]);

        if(!$videos){
            throw new DomainException('There are no free videos available', Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($videos);
    }

}