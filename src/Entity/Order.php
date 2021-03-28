<?php
namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 * @ORM\HasLifecycleCallbacks()
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=OrderHasProduits::class, mappedBy="commande", cascade={"persist"})
     */
    private $hasProduits;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->hasProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|OrderHasProduits[]
     */
    public function getHasProduits(): Collection
    {
        return $this->hasProduits;
    }

    public function addHasProduit(OrderHasProduits $hasProduit): self
    {
        if (!$this->hasProduits->contains($hasProduit)) {
            $this->hasProduits[] = $hasProduit;
            $hasProduit->setCommande($this);
        }

        return $this;
    }

    public function removeHasProduit(OrderHasProduits $hasProduit): self
    {
        if ($this->hasProduits->removeElement($hasProduit)) {
            // set the owning side to null (unless already changed)
            if ($hasProduit->getCommande() === $this) {
                $hasProduit->setCommande(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    
    /**
     * @ORM\PrePersist
    */ 
    public function setCreatedAt()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * @return float
    */ 
    public function getTotal(): float
    {
        $total = 0.00;
        
        foreach($this->getHasProduits() as $orderProduit) {
            $totalOrderProduit = $orderProduit->getProduit()->getPrix() * $orderProduit->getQuantite();  
            $total += $totalOrderProduit;
        }

        return $total;
    }

}
