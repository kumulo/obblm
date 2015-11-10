<?php
namespace BbLigueBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 */
class InitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('bbligue:media:init')
            ->setDescription('Init BbLigue Media Folders');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $baseDir = dirname($this->getContainer()->get('kernel')->getRootDir()) . '/web/';

        /** @var Filesystem $filesystem */
        $filesystem = $this->getContainer()->get('filesystem');

        $output->writeln('Create media dirs in ' . $baseDir);

        $uploadDir = $baseDir . "uploads/";

        $output->writeln('Create Upload dir in ' . $uploadDir);

        if (!is_dir($uploadDir)) {
            $filesystem->mkdir($uploadDir);
        } else {
            $output->writeLn('Directory ' . $uploadDir . ' already exists');
        }

        $mediaCacheDir = $baseDir . "media/";

        $output->writeln('Create Media Cache dir in ' . $mediaCacheDir);

        if (!is_dir($mediaCacheDir)) {
            $filesystem->mkdir($mediaCacheDir);
        } else {
            $output->writeLn('Directory ' . $mediaCacheDir . ' already exists');
        }
    }
}
