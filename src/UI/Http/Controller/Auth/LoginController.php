<?php

namespace App\UI\Http\Controller\Auth;

use App\Application\Command\Auth\Login\LoginCommand;
use App\Application\Query\Auth\GetToken\GetTokenQuery;
use App\UI\Http\Controller\AbstractBusController;
use Assert\Assertion;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class LoginController extends AbstractBusController
{
    /**
     * @Route(
     *     "/auth/login",
     *     name="auth_login",
     *     methods={"POST"},
     *     requirements={
     *      "email": "\w+",
     *      "password": "\w+"
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
     * @SWG\Tag(name="Auth")
     *
     * @throws \Assert\AssertionFailedException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $email = $request->get('email');

        Assertion::notNull($email, 'Email cant\'t be empty');

        $loginCommand = new LoginCommand($email, $request->get('password'));

        $this->handle($loginCommand);

        return JsonResponse::create(['token' => $this->ask(new GetTokenQuery($email))]);
    }
}
