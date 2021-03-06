<?php declare(strict_types=1);

namespace App\Application\Routing\Controller;

use App\Application\Enum\ResponseStatuses;
use App\Application\Request\Request;
use App\Application\Response\Response;
use JsonSerializable;

class AbstractController
{
    /**
     * @param string $content
     *
     * @return Response
     */
    protected function success(string $content): Response
    {
        return new Response($content, ResponseStatuses::OK);
    }

    /**
     * @param JsonSerializable $content
     *
     * @return Response
     */
    protected function json(JsonSerializable $content): Response
    {
        return new Response(json_encode($content), ResponseStatuses::OK);
    }

    /**
     * @param string $content
     *
     * @return Response
     */
    protected function badRequest(string $content): Response
    {
        return new Response($content, ResponseStatuses::BAD_REQUEST);
    }

    /**
     * @param string $templatePath
     * @param array  $variables
     *
     * @return Response
     */
    protected function render(string $templatePath, array $variables = []): Response
    {
        ob_start();

        include_once __DIR__ . "/../../../../../templates/{$templatePath}.tpl.php";

        $content = ob_get_contents();

        ob_end_clean();

        return new Response($content, ResponseStatuses::OK);
    }

    public function redirect(string $to)
    {
        header("Location: {$to}");
        die;
    }
}
