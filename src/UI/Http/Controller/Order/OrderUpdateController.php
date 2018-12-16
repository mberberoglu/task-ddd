<?php

namespace App\UI\Http\Controller\Order;

use App\Application\Command\Warehouse\UpdateOrderAddress\UpdateOrderAddressCommand;
use App\Application\Command\Warehouse\UpdateOrderItem\UpdateProductOrderItemCommand;
use App\Application\Query\Warehouse\FindOrder\FindOrderQuery;
use App\Application\Query\Warehouse\GetProduct\GetProductQuery;
use App\Domain\Warehouse\ValueObject\ProductId;
use App\UI\Http\Controller\AbstractBusController;
use Assert\Assertion;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class OrderUpdateController extends AbstractBusController
{
    /**
     * Update pending orders.
     *
     * @Route(
     *     "/orders/{orderNumber}",
     *     name="order_update",
     *     methods={"PUT"},
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
     * @SWG\Parameter(
     *     name="orderNumber",
     *     type="string",
     *     in="path"
     * )
     * @SWG\Parameter(
     *     name="credentials",
     *     type="object",
     *     in="body",
     *     schema=@SWG\Schema(type="object",
     *         @SWG\Property(property="address", type="string"),
     *         @SWG\Property(property="products", type="array", @SWG\Items(type="object", @SWG\Property(property="productId", type="string"), @SWG\Property(property="quantity", type="integer")))
     *
     *         )
     *     )
     * )
     *
     * @SWG\Tag(name="Order")
     *
     * @Security(name="Bearer")
     *
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(Request $request, string $orderNumber): JsonResponse
    {
        Assertion::length($orderNumber, 12);

        $order = $this->ask(new FindOrderQuery($orderNumber, $this->getUser()->userId()));

        if ($request->request->get('address')) {
            $this->handle(new UpdateOrderAddressCommand($order, $request->request->get('address')));
        }

        foreach ($request->request->get('products', []) as $item) {
            Assertion::keyExists($item, 'productId');
            Assertion::keyExists($item, 'quantity');
            Assertion::min($item['quantity'], 0);

            $product = $this->ask(new GetProductQuery(new ProductId($item['productId'])));

            $this->handle(new UpdateProductOrderItemCommand($order, $product, $item['quantity']));
        }

        $order = $this->ask(new FindOrderQuery($orderNumber, $this->getUser()->userId()));

        return $this->response(['order' => $order]);
    }
}
