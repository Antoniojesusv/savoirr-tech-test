<?php

namespace App\Controller;

use App\Mep\Application\Find\FindMepQuery;
use App\Shared\Domain\Bus\Query\Contract\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MepController extends AbstractController
{
    public function __construct(
        private QueryBus $queryBus,
    ) {
        $this->queryBus = $queryBus;
    }

    #[Route('/mep', name: 'app_map', methods: "GET")]
    public function synchronize(Request $request): JsonResponse
    {
        $content = json_decode($request->getContent(), true);

        $query = new FindMepQuery();

        $meps = $this->queryBus->dispatch($query);

        return $this->json($meps);
    }
}