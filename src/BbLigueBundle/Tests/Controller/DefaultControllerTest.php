<?php

namespace BbLigueBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient(array('environment' => 'test'));
    }
    public function testIndex()
    {
        $this->client->request('GET', '/');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->client->request('GET', '/ligue/');
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
    public function testLigue()
    {
        $container = $this->client->getContainer();
        $em = $container->get('doctrine');
        $repo = $em->getRepository('BbLigueBundle:Ligue');
        $ligues = $repo->findAll(1);
        // One ligue injected
        $this->assertCount(1, $ligues);
        foreach($ligues as $ligue) {
            $this->assertEquals('lbr6', $ligue->getRule());
        }
    }
    public function testTeams()
    {
        $container = $this->client->getContainer();
        $em = $container->get('doctrine');
        $repo = $em->getRepository('BbLigueBundle:Team');
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
        $crawler = $this->client->request('GET', '/login');
        $container = $this->client->getContainer();
        $rules = $container->get('bb.rules');
    }

    /*
     * This is broken
     */
    private function logInAsUser()
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
    }
}
