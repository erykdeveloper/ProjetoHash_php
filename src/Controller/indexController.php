<?php
// src/Controller/indexController.php
namespace App\Controller;

use App\Service\hashManagerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class indexController
{
    /**
     * @Route("/")
     */
    public function index(Request $request): Response {
        $makeHash = new hashManagerService();
        $md5 = md5($makeHash->generate(18));
        $response = <<<HTML
    <input type="text" value="$md5" placeholder="certo string kkkk">
HTML;
        return new Response($response);
    }
}
