<?php

namespace App\UI\Cli\Command;

use App\Application\Command\Auth\Register\RegisterCommand;
use App\Application\Command\Company\Establish\EstablishCommand;
use App\Application\Command\Warehouse\CreateProduct\CreateProductCommand;
use App\Application\Command\Warehouse\InventoryChange\InventoryChangeCommand;
use App\Domain\Company\Repository\CompanyRepositoryInterface;
use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\Company\ValueObject\Prefix\CompanyPrefixFactory;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\UserId;
use App\Domain\Warehouse\Repository\ProductRepositoryInterface;
use App\Domain\Warehouse\ValueObject\ProductId;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitDataCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('app:init-data')
            ->setDescription('Initialize dummy data');
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = [
            ['userId' => new UserId(), 'email' => 'u1@merchant.com'],
            ['userId' => new UserId(), 'email' => 'u2@merchant.com'],
            ['userId' => new UserId(), 'email' => 'u3@merchant.com'],
            ['userId' => new UserId(), 'email' => 'u1@cargo.com'],
            ['userId' => new UserId(), 'email' => 'u2@cargo.com'],
            ['userId' => new UserId(), 'email' => 'u3@cargo.com'],
        ];

        $companies = [
            ['companyId' => new CompanyId(), 'type' => 'merchant', 'name' => 'Acme Company', 'prefix' => 'XTR'],
            ['companyId' => new CompanyId(), 'type' => 'merchant', 'name' => 'Long Silver Co', 'prefix' => 'MKT'],
            ['companyId' => new CompanyId(), 'type' => 'merchant', 'name' => 'White Star Co', 'prefix' => 'CPU'],
            ['companyId' => new CompanyId(), 'type' => 'cargo', 'name' => 'FastCargo', 'prefix' => 'A'],
            ['companyId' => new CompanyId(), 'type' => 'cargo', 'name' => 'RabbitLines', 'prefix' => 'B'],
            ['companyId' => new CompanyId(), 'type' => 'cargo', 'name' => 'TeapotCargo', 'prefix' => 'C'],
        ];

        $products = [];

        for ($i = 1; $i < 51; ++$i) {
            $products[] = ['productId' => new ProductId('00000000-0000-0000-' . str_pad($i, '4', '0', STR_PAD_LEFT) . '-fc4ea8bb6c9e'), 'name' => 'Product ' . $i];
        }

        foreach ($users as $user) {
            $isUserCreated = $this->userRepository->findOneByEmail(Email::fromString($user['email']));
            if (!$isUserCreated) {
                $this->commandBus->handle(new RegisterCommand($user['userId'], $user['email'], '11223344'));
            }
        }

        $output->writeln('<info>Users Created</info>');

        foreach ($companies as $key => $company) {
            $isCompanyCreated = $this->companyRepository->findOneByPrefix(CompanyPrefixFactory::make($company['type'])::fromString($company['prefix']));
            $user = $this->userRepository->findOneByEmail(Email::fromString($users[$key]['email']));
            if (!$isCompanyCreated) {
                $this->commandBus->handle(new EstablishCommand($company['companyId'], $user, $company['name'], $company['type'], $company['prefix']));
            }
            $user->assignCompany($this->companyRepository->findOneByPrefix(CompanyPrefixFactory::make($company['type'])::fromString($company['prefix'])));
        }

        $output->writeln('<info>Companies Created</info>');

        $merchants = \array_slice($companies, 0, 3);

        foreach ($products as $key => $product) {
            $company = $merchants[array_rand($merchants)];
            $merchant = $this->companyRepository->findOneByPrefix(CompanyPrefixFactory::make($company['type'])::fromString($company['prefix']));
            $isProductCreated = $this->productRepository->findOneByUuid($product['productId']);
            if (!$isProductCreated) {
                $this->commandBus->handle(new CreateProductCommand($product['productId'], $merchant, $product['name']));
            }
            $product = $this->productRepository->getOneByUuid($product['productId']);
            $this->commandBus->handle(new InventoryChangeCommand($product, random_int(10, 100)));
        }

        $output->writeln('<info>Products Created</info>');
    }

    public function __construct(
        CommandBus $commandBus,
        UserRepositoryInterface $userRepository,
        CompanyRepositoryInterface $companyRepository,
        ProductRepositoryInterface $productRepository
    ) {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
}
