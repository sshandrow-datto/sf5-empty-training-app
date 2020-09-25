<?php
namespace App\Controller;

use App\Service\LuckyNumberGenerator;
use Exception;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * # method getUser(): User
 * this is fake to let the framework know what is being returned
 * You can make a baseController and shortcut methods in the base controller
 */
class LuckyController extends AbstractController
{
    private $luckyNumberGenerator;

    public function __construct(LuckyNumberGenerator $luckyNumberGenerator)
    {
        $this->luckyNumberGenerator = $luckyNumberGenerator;
    }

    /**
     * @Route("/lucky/number/{max<\d+>}", methods={"GET"}, name="app_lucky_number")
     * @ IsGranted("ROLE_ADMIN") # <-- Role Based Security Option 3: Done by an event listener
     * @param $max
     * @param LoggerInterface $logger
     * @return Response
     */
    public function number($max, LoggerInterface $logger)
    {
        # SS: Role Based Security Option 2: This does the same thing as access control
        # $this->denyAccessUnlessGranted('ROLE_ADMIN');

        # SS: Sometimes you need to make decisions based on products
        # eg. If you are creator of an object, you can edit but no one else
        

        // /** @var User $user */
        // $user = $this->getUser();

        //$number = random_int($this->globalMinNumber, $max);
        //$generator = new LuckyNumberGenerator();
        $number = $this->luckyNumberGenerator->getRandomNumber($max);

        $logger->info(sprintf('Lucky number is "%d"', $number));

        // was very common in Symfony 3
        // we basically never do this in Symfony 4/5
//        $this->container->get('logger')
//            ->info('I am logging');
//
//        // allowed with public: true
//        $this->container->get('App\Service\LuckyNumberGenerator')
//            ->getRandomNumber(5);

        //dd($this->getParameter('favorite_food'));

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

    public function numberApi($max)
    {
        $number = 0;
        try {
            $number = random_int(0, $max);
        } catch (Exception $e) {
            #logger.log("Unexpected error");
        }

        return new JsonResponse(['number' => $number]);

//        return new Response(json_encode(['number' => $number]), 200, [
//            'Content-Type' => 'application/json',
//        ]);
    }
}
