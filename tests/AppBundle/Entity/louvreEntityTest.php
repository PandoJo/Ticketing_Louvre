<?php

namespace Tests\AppBundle\Entity;



use PHPUnit\Framework\TestCase;

use App\Entity\Ticket;



class TicketTest extends TestCase

{

    public function testName()

    {

        $ticket = $this->getMockForAbstractClass('App\Entity\Ticket');

        $ticket->setName('Eric');

        $this->assertNotNull($ticket->getName());

        $this->assertEquals('Eric', $ticket->getName());

    }



    public function testSurname()

    {

        $ticket = $this->getMockForAbstractClass('App\Entity\Ticket');

        $ticket->setSurname('Durant');

        $this->assertNotNull($ticket->getSurname());

        $this->assertEquals('Durant', $ticket->getSurname());

    }



    public function testCountry()

    {

        $ticket = $this->getMockForAbstractClass('App\Entity\Ticket');

        $ticket->setCountry('FR');

        $this->assertNotNull($ticket->getCountry());

        $this->assertEquals('FR', $ticket->getCountry());

    }

    public function testReducedPrice()

    {

        $ticket = $this->getMockForAbstractClass('App\Entity\Ticket');

        $ticket->setReducedPrice(false);

        $this->assertNotNull($ticket->getReducedPrice());

        $this->assertEquals(false, $ticket->getReducedPrice());

    }



}