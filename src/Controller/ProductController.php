<?php

namespace App\Controller;

use App\Exception\FilterException;
use App\Repository\ProductRepository;
use App\Service\ProductDiscountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var ProductDiscountService
     */
    private $productDiscountService;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository, ProductDiscountService $productDiscountService)
    {
        $this->productRepository = $productRepository;
        $this->productDiscountService = $productDiscountService;
    }

    /**
     * @Route("/products", methods={"GET"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getIndex(Request $request, SerializerInterface $serializer): JsonResponse
    {
        if (!$request->query->get('category')) {
            throw new FilterException();
        }

        $products = $this->productRepository->search(
            $request->query->get('category'),
            $request->query->get('price')
        );

        if (!$products->count()) {
            throw new NotFoundHttpException('Products not found');
        }

        foreach($products as $product) {
            $product->setPrice($this->productDiscountService->apply($product));
        }

        return $this->json($serializer->normalize($products, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['cost']]));
    }
}
