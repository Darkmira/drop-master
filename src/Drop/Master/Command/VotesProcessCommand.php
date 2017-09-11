<?php

namespace Drop\Master\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Drop\Master\Service\InnocentHand;

class VotesProcessCommand extends Command
{
    /**
     * @var InnocentHand
     */
    private $innocentHand;

    /**
     * @param InnocentHand $innocentHand
     */
    public function __construct(InnocentHand $innocentHand)
    {
        parent::__construct('drop:votes:process');

        $this->innocentHand = $innocentHand;
    }

    /**
     * {@InheritDoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setDescription('Process player votes and send instructions to robots.')
        ;
    }

    /**
     * {@InheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ordersSent = $this->innocentHand->sessionCooldown();

        if (0 === count($ordersSent)) {
            $output->writeln('Nothing sent to robots as there is no one vote from players in teams.');
        } else {
            $output->writeln('Message sent to fleet control api:');
            $output->writeln(json_encode($ordersSent));
        }

        $output->writeln('Players votes have been reinitialized.');
        $output->writeln('');
    }
}
