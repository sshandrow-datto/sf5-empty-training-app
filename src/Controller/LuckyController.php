<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController
{
    /**
     * @Route("/lucky/number/{max<\d+>}", methods={"GET"})
     */
    public function number($max)
    {
        $number = random_int(0, $max);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    public function numberApi($max)
    {
        $number = random_int(0, $max);

        return new JsonResponse(['number' => $number]);

//        return new Response(json_encode(['number' => $number]), 200, [
//            'Content-Type' => 'application/json',
//        ]);
    }
}