<?php

namespace App\UI\Http\Controller;

use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractController.
 */
abstract class AbstractController
{
    use ControllerTrait;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param string $route
     * @param int    $statusCode
     *
     * @return \FOS\RestBundle\View\View
     */
    protected function routeRedirectView(
        $route,
        array $parameters = [],
        $statusCode = Response::HTTP_CREATED,
        array $headers = []
    ) {
        return View::createRouteRedirect(
            $route,
            array_merge(
                [
                'version' => $this->getVersion(),
                '_format' => $this->getFormat(),
            ],
                $parameters
            ),
            $statusCode,
            $headers
        );
    }

    public function getFormat(): string
    {
        return $this->getRequest()->getRequestFormat('json');
    }

    public function getVersion(): string
    {
        return $this->getRequest()->attributes->get('version') ?: 'v1';
    }

    protected function getRequest(): ?Request
    {
        return $this->requestStack->getMasterRequest();
    }

    protected function response($data = null, $status = 200): JsonResponse
    {
        if ($data) {
            $json = $this->serializer->serialize($data, 'json');
            $data = json_decode($json, 1);
        }

        return JsonResponse::create($data, $status);
    }
}
