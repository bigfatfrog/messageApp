<?php


namespace App\Commands;

use App\Services\RabbitService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RabbitCommand extends Command
{
    protected static $defaultName = 'app:rabbit-receive';

    public function __construct(RabbitService $rabbitService)
    {
        parent::__construct();

        $this->rabbitService = $rabbitService;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->rabbitService->receive();
        return Command::SUCCESS;
    }

}
