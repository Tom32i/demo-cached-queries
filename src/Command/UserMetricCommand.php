<?php

namespace App\Command;

use App\Query\GetUserMetricsQuery;
use App\Stamp\RefreshCacheStamp;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:user-metric',
    description: 'Add a short description for your command',
)]
class UserMetricCommand extends Command
{
    public function __construct(
        private MessageBusInterface $bus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('userId', InputArgument::REQUIRED, 'User id')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force cache resfresh')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $stamps = [];

        if ($input->getOption('force')) {
            $stamps[] = new RefreshCacheStamp();
        }

        $envelope = $this->bus->dispatch(
            new GetUserMetricsQuery(
                $input->getArgument('userId')
            ),
            $stamps
        );

        $result = $envelope->last(HandledStamp::class)->getResult();

        $io->table(array_keys($result), [$result]);

        return Command::SUCCESS;
    }
}
