<?php
namespace App\Tests\Entity;

use App\Entity\Manga;
use PHPUnit\Framework\TestCase;

class MangaTest extends TestCase
{
    public function testSetName()
    {
        $manga = new Manga();
        $manga->setName('Naruto');

        $this->assertEquals('Naruto', $manga->getName());
    }
}
