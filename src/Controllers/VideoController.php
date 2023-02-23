<?php 

namespace App\Controllers;

use App\Http\Response\Response as JsonResponse;
use App\Models\Video;
use Doctrine\ORM\EntityManagerInterface;
use DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends AbstractController {

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index() : Response
    {

        $videoRepository = $this->entityManager->getRepository(Video::class);

        $videos = $videoRepository->findAll();

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

        $video = new Video();

        $video->setTitle($requestData['title'] ?? '');
        $video->setUrl($requestData['url'] ?? '');
        $video->setDescription($requestData['description'] ?? '');
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
            throw new DomainException('Video not found', Response::HTTP_NOT_FOUND);
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
            throw new DomainException('Video not found', Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($video);
        $this->entityManager->flush();

        return new JsonResponse(
            data: ['message' => 'Video deleted successfully'],
            json: false
        );
    }

}