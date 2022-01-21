<?php
// src/Controller/hashController.php
namespace App\Controller;

use App\Entity\Hashs;
use App\Repository\HashsRepository;
use App\Service\hashManagerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class hashController extends AbstractController
{
    /**
     * @Route("/hash")
     */
    public function hash(Request $request): Response
    {
        $makeHash = new hashManagerService();
        $response = 'dsada';
        return $this->render('hash.html.twig', [
            'number' => 'dasdasds',
        ]);
    }

    /**
     * @param Request $request
     * @param ManagerRegistry $registry
     * @return Response
     * @Route ("/api/gethash/{string}/{requests}")
     */
    public function apiGetHash(Request $request, ManagerRegistry $registry): Response
    {
        $string = (string)$request->get(key: 'string');
        $req = (int)$request->get(key: 'requests');
        $hashManagerService = new hashManagerService();
        $doctrine = $registry->getManager();
        $hashIdentifier = $hashManagerService->generate();
        for ($i=0;$i<$req;$i++) {
            $hashObject = new Hashs();
            $stringForSearch = $stringForSearch['hash'] ?? $string;
            $hashObject->setBatch(\DateTimeImmutable::createFromFormat('Y-m-d H:i', date('Y-m-d H:i')));
            $hashObject->setNblock(($i+1));
            $hashObject->setString($stringForSearch);
            $stringForSearch = $hashManagerService->search($stringForSearch);
            $hashObject->setGeneratedkey($stringForSearch['key']); // Key gerada
            $hashObject->setGeneratedhash($stringForSearch['hash']); // Chave gerada
            $hashObject->setAttemps($stringForSearch['attemps']);
            $hashObject->sethashIdentifier($hashIdentifier);
            $doctrine->persist($hashObject);
        }
        $doctrine->flush();
        $hashInserted = $doctrine->getRepository(Hashs::class)->findBy(['hashIdentifier' => $hashIdentifier]);
        $forTableCLI = [];
        foreach ($hashInserted as $key => $value) {
            $forTableCLI[] = array(
                "getId" => $value->getId(),
                "getBatch" => $value->getBatch()->format('Y-m-d H:i:s'),
                "getNblock" => $value->getNblock(),
                "getString" => $value->getString(),
                "getGeneratedkey" => $value->getGeneratedkey(),
                "getGeneratedhash" => $value->getGeneratedhash(),
                "getAttemps" => $value->getAttemps(),
                "getHashIdentifier" => $value->getHashIdentifier()
            );
        }
        $response = new Response();
//        $response
//            ->setStatusCode(code: 429)
//            ->setContent(content: 'Too many Attemps');
//        return $response;
        return $this->render('hash.html.twig', [
            'hashInserted' => $forTableCLI
        ]);
    }
}
