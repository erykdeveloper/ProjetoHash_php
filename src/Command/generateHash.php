<?php

namespace App\Command;

use App\Entity\Hashs;
use App\Repository\HashsRepository;
use App\Service\hashManagerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class generateHash extends Command
{
    protected static $defaultName = 'avato:test';
    protected static $defaultDescription = 'Default Dequipition';
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('Para usar o comando faça isso :3')
            ->addOption(
                name: 'requests',
                mode: InputOption::VALUE_REQUIRED,
                description: 'Quantidades de hash/bloco/oquefor',
                default: 1
            )
            ->addArgument(
                name: 'string',
                mode: InputArgument::REQUIRED,
                description: 'Qual a string?'
            );
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = new Table($output);
        $string = $input->getArgument('string') ?? '';
        $req = $input->getOption('requests') ?? '';

        $hashManagerService = new hashManagerService();
        $doctrine = $this->entityManager;
        $hashIdentifier = $hashManagerService->generate();

        $listHash = [];
        for ($i=0;$i<$req;$i++) {
            $hashObject = new Hashs();
            $stringForSearch = $stringForSearch['hash'] ?? $string;
            $hashObject->setBatch(new \DateTime());
            $hashObject->setNblock(($i+1));
            $hashObject->setString($stringForSearch);
            $stringForSearch = $hashManagerService->search($stringForSearch);
            $hashObject->setGeneratedkey($stringForSearch['key']); // Key gerada
            $hashObject->setGeneratedhash($stringForSearch['hash']); // Chave gerada
            $hashObject->setAttemps($stringForSearch['attemps']);
            $hashObject->sethashIdentifier($hashIdentifier);
            $listHash[] = $hashObject;
            $doctrine->persist($hashObject);
        }
        $doctrine->flush();

        $hashInserted = (array) $doctrine->getRepository(Hashs::class)->findBy(['hashIdentifier' => $hashIdentifier]);
        $forTableCLI = [];
        foreach ($hashInserted as $key => $value) {
            $forTableCLI[] = array(
                $value->getId(),
                $value->getBatch()->format('Y-m-d H:i:s'),
                $value->getNblock(),
                $value->getString(),
                $value->getGeneratedkey(),
                $value->getGeneratedhash(),
                $value->getAttemps(),
                $value->getHashIdentifier()
            );
        }
        $table
            ->setHeaders(['id', 'batch', 'nblock', 'string', 'generatedkey', 'generatedhash', 'attemps', 'hashIdentifier'])
            ->setRows($forTableCLI)
        ;
        $table->render();
        return Command::SUCCESS;
    }
}
