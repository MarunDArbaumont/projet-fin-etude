<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class RegisterControllerTest extends WebTestCase
{
    public function testRegisterPageLoadsSuccessfully(): void
    {
        $client = static::createClient();
        $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Register');
    }

    public function testSuccessfulRegistration(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $form = $crawler->selectButton('Register')->form([
            'register[email]' => 'testuser@example.com',
            'register[plainPassword]' => 'TestPassword123!',
            'register[name]' => 'Test User',
        ]);

        $client->submit($form);

        // Ensure the form submission redirects (e.g., to login page)
        $this->assertResponseRedirects('/login');

        // Follow the redirection
        $client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Login');
    }

    public function testUserIsCreatedInDatabase(): void
    {
        $client = static::createClient();
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $userRepository = $entityManager->getRepository(UserRepository::class);

        $user = $userRepository->findOneBy(['email' => 'testuser@example.com']);
        $this->assertNotNull($user, 'User was not found in the database');
    }
}
