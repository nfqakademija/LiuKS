<?php

namespace Liuks\GameBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GamesDataUpdateCommand extends ContainerAwareCommand
{
    private $output;

    protected function configure()
    {
        $this
            ->setName('gamesdata:update')
            ->setDescription('Connects to API and updates games data.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Updating games data...</comment>');
        $this->output = $output;

        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        $tables = $em->getRepository('LiuksTableBundle:Table')->findAll();

        foreach ($tables as $table) {
            if (time() >= $table->getLastDataUpdate() + 60) {
                $output->writeln(sprintf('Updating table <info>%d</info> data', $table->getId()));
                try {
                    $this->getContainer()->get('table_actions.service')->updateTableData($table);
                } catch (\Exception $e) {
                    $output->writeln('<error>' . $e->getMessage() . '</error>');
                }
            } else {
                $output->writeln('Skipping Table <info>'.$table->getId().'</info>');
            }
        }
        $em->flush($tables);
        $output->writeln('<comment>Done!</comment>');
    }
}
