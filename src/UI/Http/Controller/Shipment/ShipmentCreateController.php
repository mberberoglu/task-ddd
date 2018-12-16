<?php

namespace App\UI\Http\Controller\Shipment;

use App\Application\Command\Warehouse\CreateShipment\CreateShipmentCommand;
use App\Application\Query\Company\FindCompany\FindCompanyQuery;
use App\Application\Query\User\FindUser\FindUserQuery;
use App\Application\Query\Warehouse\FindOrder\FindOrderQuery;
use App\Domain\Company\Model\Company;
use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\ValueObject\ShipmentType;
use App\UI\Http\Controller\AbstractBusController;
use Assert\Assertion;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ShipmentCreateController extends AbstractBusController
{
    /**
     * Ships pending order.
     *
     * @Route(
     *     "/shipments/{orderNumber}",
     *     name="shipment_create",
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
     *     name="orderNumber",
     *     type="string",
     *     in="path"
     * )
     *
     * @SWG\Tag(name="Shipment")
     *
     * @Security(name="Bearer")
     *
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(string $orderNumber): JsonResponse
    {
        $user = $this->ask(FindUserQuery::byUserId($this->getUser()->userId()));
        /** @var Company $company */
        $company = $this->ask(FindCompanyQuery::byCompanyId($this->getUser()->companyId()));

        Assertion::eq($company->type()->toString(), 'cargo');

        /** @var Order $order */
        $order = $this->ask(new FindOrderQuery($orderNumber));

        $this->handle(new CreateShipmentCommand($order, $company, $user, ShipmentType::DELIVERY));

        return $this->response(['order' => $order], JsonResponse::HTTP_CREATED);
    }
}
