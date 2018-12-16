<?php

namespace App\UI\Http\Controller\Product;

use App\Application\Query\Warehouse\GetProductsByCompany\GetProductsByCompanyQuery;
use App\UI\Http\Controller\AbstractBusController;
use Assert\Assertion;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ProductListController extends AbstractBusController
{
    /**
     * List products.
     *
     * @Route(
     *     "/products",
     *     name="product_list",
     *     methods={"GET"},
     *     requirements={
     *      "from": "\d+",
     *      "limit": "\d+"
     *     }
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Login success"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Bad credentials"
     * )
     * @SWG\Parameter(
     *     name="from",
     *     in="query",
     *     type="integer",
     *     required=false,
     *     default="0"
     * )
     * @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     type="integer",
     *     required=false,
     *     default="50"
     * )
     *
     * @SWG\Tag(name="Product")
     *
     * @Security(name="Bearer")
     *
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(Request $request): JsonResponse
    {
        Assertion::min($request->query->getInt('limit', 50), 5);
        Assertion::min($request->query->getInt('from', 0), 0);

        $collection = $this->ask(new GetProductsByCompanyQuery($this->getUser()->companyId(), $request->query->getInt('from', 0), $request->query->getInt('limit', 50)));

        return $this->response($collection);
    }
}
