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
        $output->writeln('<comment>Running Cron Tasks...</comment>');
        $this->output = $output;

        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');
        $tables = $em->getRepository('LiuksTableBundle:Table')->findAll();

        foreach ($tables as $table) {
            $lastrun = $table->getLastDataUpdate();
            $nextrun = $lastrun + 60;

            if (time() >= $nextrun) {
                $output->writeln(sprintf('Running Cron Task on table <info>%d</info>', $table->getId()));

                $table->setLastDataUpdate(time());
                try {
                    $records = $container->get('api_data.service')->getData($table->getApi(), $table->getLastEventId());
                    if ($records) {
                        foreach ($records as $record) {
                            $action = $record->type;
                            $container->get('table_actions.service')->handleTableAction($table, $record);
                            $output->writeln('Success! Action completed: <info>'.$action.'</info>');
                        }
                        $table->setLastEventId(end($records)->id);
                    }
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
