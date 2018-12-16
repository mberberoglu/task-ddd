<?php

namespace App\UI\Http\Controller\Order;

use App\Application\Command\Warehouse\CancelOrder\CancelOrderCommand;
use App\Application\Query\Warehouse\FindOrder\FindOrderQuery;
use App\UI\Http\Controller\AbstractBusController;
use Assert\Assertion;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class OrderCancelController extends AbstractBusController
{
    /**
     * Cancel Order.
     *
     * @Route(
     *     "/orders/{orderNumber}",
     *     name="order_cancel",
     *     methods={"DELETE"},
     *     requirements={
     *      "orderNumber": "\w+"
     *     }
     * )
     *
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
     *     name="orderNumber",
     *     type="string",
     *     in="path"
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

        $this->handle(new CancelOrderCommand($orderNumber));

        $order = $this->ask(new FindOrderQuery($orderNumber, $this->getUser()->userId()));

        return $this->response(['order' => $order]);
    }
}
