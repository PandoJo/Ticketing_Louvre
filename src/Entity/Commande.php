<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $VisitDay;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TicketType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="commande", orphanRemoval=true)
     * 
     * @Assert\Count(min=1,minMessage="Vous devez avoir minimum un ticket pour effectuer une commande.")
     */
    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisitDay(): ?\DateTimeInterface
    {
        return $this->VisitDay;
    }

    public function setVisitDay(\DateTimeInterface $VisitDay): self
    {
        $this->VisitDay = $VisitDay;

        return $this;
    }

    public function getTicketType(): ?string
    {
        return $this->TicketType;
    }

    public function setTicketType(string $TicketType): self
    {
        $this->TicketType = $TicketType;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setCommande($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getCommande() === $this) {
                $ticket->setCommande(null);
            }
        }

        return $this;
    }
}
