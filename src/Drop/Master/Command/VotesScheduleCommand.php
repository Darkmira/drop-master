<?php

namespace Drop\Master\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Drop\Master\Service\InnocentHand;
use Drop\Master\Service\VoteSessionHandler;

class VotesScheduleCommand extends Command
{
    /**
     * @var InnocentHand
     */
    private $innocentHand;

    /**
     * @var VoteSessionHandler
     */
    private $voteSessionHandler;

    /**
     * @param InnocentHand $innocentHand
     * @param VoteSessionHandler $voteSessionHandler
     */
    public function __construct(InnocentHand $innocentHand, VoteSessionHandler $voteSessionHandler)
    {
        parent::__construct('drop:votes:schedule');

        $this->innocentHand = $innocentHand;
        $this->voteSessionHandler = $voteSessionHandler;
    }

    /**
     * {@InheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('Process player votes and send instructions to robots every X seconds.')
            ->addArgument(
                'schedule-interval',
                InputArgument::OPTIONAL,
                'In seconds, define time between votes process.',
                20
            )
        ;
    }

    /**
     * {@InheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sessionDuration = $input->getArgument('schedule-interval');

        if (false === $sessionDuration) {
            $this->processVotes($output);
            return;
        }

        while (true) {
            $this->voteSessionHandler->startNew($sessionDuration);

            $output->writeln("Waiting $sessionDuration seconds...");
            sleep($sessionDuration);

            $this->processVotes($output);
        }
    }

    private function processVotes(OutputInterface $output)
    {
        $result = shell_exec('bin/console drop:votes:process');
        $output->write($result);
    }
}
