<?php

namespace App\Command;

use App\Entity\Rule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class RulesLoaderCommand extends Command {

    protected static $defaultName = 'obblm:rules:load';
    protected static $rulesDirectory = 'datas/rules';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Loads Blood Bowl core rules.')
            ->setHelp('This command will add core Blood Bowl rules to the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rules = [];
        $finder = new Finder();

        $finder->files()->name(['*.yaml', '*.yml'])->in(self::$rulesDirectory);
        if ($finder->hasResults()) {
            foreach($finder as $file) {
                $content = Yaml::parseFile($file->getPathname());
                $rules = array_merge_recursive($rules, $content);
            }
            foreach($rules['rules'] as $key => $rule_array) {
                $rule = $this->em->getRepository(Rule::class)->findOneBy(['rule_key' => $key]);
                if(!$rule) {
                    $rule = (new Rule())
                        ->setRuleKey($key)
                        ->setReadOnly(true);
                }

                $rule
                    ->setName($key)
                    ->setPostBb2020($rule_array['post_bb_2020'] ?? false)
                    ->setRule($rule_array)
                ;
                $output->writeln("Saving : " . $key);
                $this->em->persist($rule);
            }
            $this->em->flush();
            return 0;
        }

        return 1;
    }
}