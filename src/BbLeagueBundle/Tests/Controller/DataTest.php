<?php

namespace BbLeagueBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DataTest extends WebTestCase
{
    private $client = null;
    private $container = null;

    protected function createWebClient()
    {
        if(!$this->client) {
            $this->client = static::createClient(array('environment' => 'test'));
        }
    }
    public function testIndex()
    {
        $this->createWebClient();
        $this->client->request('GET', '/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->request('GET', '/leagues/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->request('GET', '/coach/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->request('GET', '/admin/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }
    /*
     * TODO : Login tests are broken
    public function testUser() {
        $this->logInAsUser();
        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    public function testAdmin() {
        $this->logInAsAdmin();

        $crawler = $this->client->request('GET', '/');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertGreaterThan(0, $crawler->filter('#navigation:contains("Espace admin")')->count());
    }*/
    public function testLeague()
    {
        $this->createWebClient();
        $container = $this->client->getContainer();
        $em = $container->get('doctrine');
        $repo = $em->getRepository('BbLeagueBundle:League');
        $leagues = $repo->findAll(1);
        // One league injected
        $this->assertCount(1, $leagues);
        foreach($leagues as $league) {
            $this->assertEquals('lrb6', $league->getRule());
        }
    }
    public function testTeams()
    {
        $this->createWebClient();
        $container = $this->client->getContainer();
        $em = $container->get('doctrine');
        $repo = $em->getRepository('BbLeagueBundle:Team');
        $teams = $repo->findAll();
        // Four teams injected
        $this->assertCount(8, $teams);
        foreach($teams as $team) {
            $this->assertTrue(
                in_array(
                    $team->getRoster(),
                    array(
                        'dwarf',
                        'ogre',
                        'dark_elf',
                        'high_elf',
                        'necromantic',
                        'human',
                        'goblin',
                        'amazon'
                    )
                )
            );
        }
    }
    // TODO : Add more data tests
    public function testService()
    {
        $this->createWebClient();
        $rules = $this->client->getContainer()->get('bb.rules');
        $rule = $rules->getRule('lrb6');
        $this->assertEquals('1000000', $rule->getMaxTeamCost());
        $this->assertEquals('veteran', $rule->getExperienceLevelForValue(16));
        $injury = $rule->getInjury(53);
        $this->assertEquals('smashed_hip', $injury['key_name']);
    }

    /*
     * This is broken
     */
    /*private function logInAsUser()
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken('user', null, $firewall, array('ROLE_USER'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
    private function logInAsAdmin()
    {
        $session = $this->client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken('admin', null, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }*/
}
