<?php

namespace App\UI\Http\Controller\Order;

use App\Application\Command\Warehouse\CreateOrder\CreateOrderCommand;
use App\Application\Query\Company\FindCompany\FindCompanyQuery;
use App\Application\Query\User\FindUser\FindUserQuery;
use App\Application\Query\Warehouse\GetOrder\GetOrderQuery;
use App\Application\Query\Warehouse\GetProduct\GetProductQuery;
use App\Domain\Company\Model\Company;
use App\Domain\Warehouse\ValueObject\OrderId;
use App\Domain\Warehouse\ValueObject\ProductId;
use App\Domain\Warehouse\ValueObject\ProductOrderQuantity;
use App\UI\Http\Controller\AbstractBusController;
use Assert\Assertion;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class OrderCreateController extends AbstractBusController
{
    /**
     * Creates new order.
     *
     * @Route(
     *     "/orders",
     *     name="order_create",
     *     methods={"POST"},
     *     requirements={
     *      "address": "\w+"
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
    public function __invoke(Request $request): JsonResponse
    {
        $user = $this->ask(FindUserQuery::byUserId($this->getUser()->userId()));
        /** @var Company $company */
        $company = $this->ask(FindCompanyQuery::byCompanyId($this->getUser()->companyId()));

        Assertion::eq($company->type()->toString(), 'merchant');

        $orderId = new OrderId();

        $productItems = [];
        foreach ($request->request->get('products', []) as $productItem) {
            Assertion::keyExists($productItem, 'productId');
            Assertion::keyExists($productItem, 'quantity');

            $product = $this->ask(new GetProductQuery(new ProductId($productItem['productId']), $company->uuid()));
            Assertion::notNull($product);

            $productItems[] = new ProductOrderQuantity($product, $productItem['quantity']);
        }

        $this->handle(new CreateOrderCommand($orderId, $company, $user, $request->request->get('address'), $productItems));

        $order = $this->ask(new GetOrderQuery($orderId));

        return $this->response(['order' => $order], JsonResponse::HTTP_CREATED);
    }
}
