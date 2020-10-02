<?php


namespace App\Tests\Functional\Application\Service;


use App\Api\Infrastructure\Persistence\UserRepository;
use App\Api\Model\Entity\User;
use App\Showroom\Application\Exception\CarModelNotFoundException;
use App\Showroom\Application\Exception\CustomerNotFoundException;
use App\Showroom\Application\Trade\TradeService;
use App\Showroom\Infrastructure\Persistence\CarModelRepository;
use App\Showroom\Infrastructure\Persistence\CustomerRepository;
use App\Showroom\Infrastructure\Persistence\TradeInDealRepository;
use App\Showroom\Model\Customer\Customer;
use App\Tests\Fixture\CarModelFixture;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TradeServiceTest extends KernelTestCase
{
    private EntityManager $entityManager;

    private CarModelRepository $carModelRepository;

    private CustomerRepository $customerRepository;

    private TradeInDealRepository $tradeInDealRepository;

    private UserRepository $userRepository;

    private TradeService $tradeService;

    private CarModelFixture $carModelFixture;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->carModelRepository = $this->entityManager->getRepository('App\Showroom\Model\CarModel\CarModel');

        $this->customerRepository = $this->entityManager->getRepository('App\Showroom\Model\Customer\Customer');

        $this->tradeInDealRepository = $this->entityManager->getRepository('App\Showroom\Model\TradeInDeal\TradeInDeal');

        $this->userRepository = $this->entityManager->getRepository('App\Api\Model\Entity\User');

        $this->tradeService = new TradeService(
            $this->tradeInDealRepository,
            $this->carModelRepository,
            $this->customerRepository
        );

        $this->carModelFixture = new CarModelFixture();
    }

    /**
     * @test
     */
    public function unknownCustomer()
    {
        $this->expectException(CustomerNotFoundException::class);
        $this->tradeService->sellCarToShowroom(9, 1);
    }

    /**
     * @test
     */
    public function unknownCarModel()
    {
        $user = new User();
        $user->setUsername('test');
        $user->setPassword('test');
        $this->entityManager->persist($user);

        $customer = new Customer();
        $customer->setUserAccount($user);
        $this->customerRepository->store($customer);
        $this->expectException(CarModelNotFoundException::class);
        $this->tradeService->sellCarToShowroom(999, $customer->getId());
    }

    /**
     * @test
     */
    public function isTradeInDealCreated()
    {
        $carModel = $this->carModelFixture->get(CarModelFixture::DEFAULT_MODEL);
        $this->entityManager->persist($carModel);
        $this->entityManager->flush();

        $tradeInDeal = $this->tradeService->sellCarToShowroom(
            $this->carModelRepository->find(1)->getId(),
            $this->customerRepository->find(1)->getId()
        );

        $this->assertEquals($tradeInDeal, $this->tradeInDealRepository->find(1));
    }

    public function isTradeInDealFinished()
    {
        $carModel = $this->carModelRepository->find(1);

        $tradeInDeal = $this->tradeService->buyCarWithASurcharge(
            $carModel->getPrice()->getPrice() - $carModel->getPrice()->getTradeInPrice(),
            $this->customerRepository->find(1)->getId()
        );

        $this->assertEquals($tradeInDeal, $this->tradeInDealRepository->find(1));
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
    }
}