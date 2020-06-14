<?php declare(strict_types=1);

namespace App\Http\Controller\Auth;

use App\Application\Enum\RequestMethods;
use App\Application\Request\Request;
use App\Application\Request\SuccessResponse;
use App\Application\Response\Response;
use App\Application\Routing\Controller\AbstractController;
use App\Application\Routing\Controller\ControllerInterface;
use App\Auth\AuthService;
use App\Exception\ApiException;
use App\Exception\FirebaseApiException;

class RegisterController extends AbstractController implements ControllerInterface
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getResponse(Request $request): Response
    {
        if ($request->getMethod() === RequestMethods::GET) {
            return $this->handleGetRequest();
        }
        else {
            return $this->handlePostRequest($request);
        }
    }

    /**
     * @return Response
     */
    private function handleGetRequest(): Response
    {
        return $this->render('auth/register');
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws FirebaseApiException
     */
    private function handlePostRequest(Request $request): Response
    {
        $post = $request->getPostData();

        $email    = $post['email'] ?? '';
        $password = $post['password'] ?? '';
        $name     = $post['name'] ?? '';

        try {
            $this->authService->register($email, $password, $name);

            return $this->json(new SuccessResponse());
        }
        catch (ApiException $e) {
            return $this->json($e);
        }
    }
}
