<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BandRepository::class)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkInstagram = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkYoutube = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkFacebook = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $iframeYoutube = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'band', orphanRemoval: true , cascade: ['all'])]
    private Collection $product;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $iframe_bandcamp = null;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): static
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getLinkInstagram(): ?string
    {
        return $this->linkInstagram;
    }

    public function setLinkInstagram(?string $linkInstagram): static
    {
        $this->linkInstagram = $linkInstagram;

        return $this;
    }

    public function getLinkYoutube(): ?string
    {
        return $this->linkYoutube;
    }

    public function setLinkYoutube(?string $linkYoutube): static
    {
        $this->linkYoutube = $linkYoutube;

        return $this;
    }

    public function getLinkFacebook(): ?string
    {
        return $this->linkFacebook;
    }

    public function setLinkFacebook(?string $linkFacebook): static
    {
        $this->linkFacebook = $linkFacebook;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIframeYoutube(): ?string
    {
        return $this->iframeYoutube;
    }

    public function setIframeYoutube(?string $iframeYoutube): static
    {
        $this->iframeYoutube = $iframeYoutube;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
            $product->setBand($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getBand() === $this) {
                $product->setBand(null);
            }
        }

        return $this;
    }

    public function getIframeBandcamp(): ?string
    {
        return $this->iframe_bandcamp;
    }

    public function setIframeBandcamp(?string $iframe_bandcamp): static
    {
        $this->iframe_bandcamp = $iframe_bandcamp;

        return $this;
    }
}
