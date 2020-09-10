<?php

namespace BBlm\Command;

use BBlm\Entity\Rule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class RulesLoaderCommand extends Command {

    protected static $defaultName = 'bblm:rules:load';
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
        $finder = new Finder();
        $io = new SymfonyStyle($input, $output);
        $io->title("Importing pre fetched rules from " . self::$rulesDirectory);
        $finder->directories()->ignoreDotFiles(true)->depth(0)->in(self::$rulesDirectory);
        if ($finder->hasResults()) {
            foreach ($finder as $ruleDirectory) {
                $rules = [];
                $key = $ruleDirectory->getFilename();
                $io->block("Importing {$key} rules form {$ruleDirectory->getPathname()}");
                $fileFinder = new Finder();
                $fileFinder->files()->ignoreDotFiles(true)->name(['*.yaml', '*.yml'])->in($ruleDirectory->getPathname());
                if ($fileFinder->hasResults()) {
                    $io->progressStart($finder->count());
                    foreach($fileFinder as $file) {
                        $content = Yaml::parseFile($file->getPathname());
                        $rules = array_merge_recursive($rules, $content);
                        $io->progressAdvance(1);
                    }
                    if(!isset($rules['rules'][$key])) {
                        $io->error("The rules.{$key} rule does not exist in {$ruleDirectory->getPathname()} directory.");
                    }
                    $rule_array = $rules['rules'][$key];
                    $rule = $this->em->getRepository(Rule::class)->findOneBy(['rule_key' => $key]);
                    if(!$rule) {
                        $rule = (new Rule())
                            ->setRuleKey($key)
                            ->setReadOnly(true);
                    }
                    ksort($rule_array['rosters']);
                    $rule
                        ->setName($key)
                        ->setPostBb2020($rule_array['post_bb_2020'] ?? false)
                        ->setRule($rule_array)
                    ;
                    $this->em->persist($rule);
                    $io->progressFinish();
                }
                else {
                    $io->warning("There is no rule files in {$ruleDirectory->getPathname()} directory.");
                }
            }
            $this->em->flush();
            $io->success('All rules have been created or updated.');
            return 0;
        }

        return 1;
    }
}