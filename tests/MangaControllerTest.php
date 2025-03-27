<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MangaControllerTest extends WebTestCase
{
    public function testMangaPageLoads()
    {
        $client = static::createClient();
        $client->request('GET', '/manga');

        $this->assertResponseIsSuccessful(); // Status code 200
        $this->assertSelectorTextContains('h1', 'Manga List'); // Check if the page has <h1>Manga List</h1>
    }

    public function testSubmitNewMangaForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/manga/new');

        $form = $crawler->selectButton('Ajouter un manga')->form([
            'manga[name]' => 'One Piece',
            'manga[description]' => 'A story about pirates',
            'manga[author]' => 'Eiichiro Oda',
            'manga[releaseDate]' => '1997-07-22',
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/manga'); // Ensure it redirects after form submission
        $client->followRedirect();
        $this->assertSelectorTextContains('body', 'One Piece'); // Ensure manga appears on the page
    }
}
