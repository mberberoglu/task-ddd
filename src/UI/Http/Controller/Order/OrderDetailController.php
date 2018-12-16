<?php

namespace App\UI\Http\Controller\Order;

use App\Application\Query\Warehouse\FindOrder\FindOrderQuery;
use App\UI\Http\Controller\AbstractBusController;
use Assert\Assertion;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class OrderDetailController extends AbstractBusController
{
    /**
     * Returns order details to company.
     *
     * @Route(
     *     "/orders/{orderNumber}",
     *     name="order_detail",
     *     methods={"GET"},
     *     requirements={
     *      "orderNumber": "\w+"
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
     *     name="credentials",
     *     type="object",
     *     in="body",
     *     schema=@SWG\Schema(type="object",
     *         @SWG\Property(property="email", type="string"),
     *         @SWG\Property(property="password", type="string")
     *     )
     * )
     *
     * @SWG\Tag(name="Order")
     *
     * @Security(name="Bearer")
     *
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(string $orderNumber): JsonResponse
    {
        Assertion::length($orderNumber, 12);

        $order = $this->ask(new FindOrderQuery($orderNumber, $this->getUser()->userId()));

        return $this->response(['order' => $order]);
    }
}
