<?php

namespace App\UI\Http\Controller\Auth;

use App\Application\Command\Auth\Register\RegisterCommand;
use App\Application\Query\Auth\GetToken\GetTokenQuery;
use App\Domain\User\ValueObject\UserId;
use App\UI\Http\Controller\AbstractBusController;
use Assert\Assertion;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class RegisterController extends AbstractBusController
{
    /**
     * @Route(
     *     "/auth/register",
     *     name="auth_register",
     *     methods={"POST"},
     *     requirements={
     *      "email": "\w+",
     *      "password": "\w+"
     *     }
     * )
     *
     * @SWG\Response(
     *     response=201,
     *     description="User created successfully"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request"
     * )
     * @SWG\Response(
     *     response=409,
     *     description="Conflict"
     * )
     * @SWG\Parameter(
     *     name="user",
     *     type="object",
     *     in="body",
     *     schema=@SWG\Schema(type="object",
     *         @SWG\Property(property="email", type="string"),
     *         @SWG\Property(property="password", type="string")
     *     )
     * )
     *
     * @SWG\Tag(name="Auth")
     *
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $uuid = new UserId();
        $email = $request->get('email');
        $plainPassword = $request->get('password');

        Assertion::notNull($uuid, "Uuid can\'t be null");
        Assertion::notNull($email, "Email can\'t be null");
        Assertion::notNull($plainPassword, "Password can\'t be null");

        $commandRequest = new RegisterCommand($uuid, $email, $plainPassword);

        $this->handle($commandRequest);

        return JsonResponse::create(['token' => $this->ask(new GetTokenQuery($email))], JsonResponse::HTTP_CREATED);
    }
}
