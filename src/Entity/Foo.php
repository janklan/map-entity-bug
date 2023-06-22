<?php

namespace App\Entity;

use App\Repository\FooRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FooRepository::class)]
class Foo implements \Stringable
{
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $children;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'tree')]
    private ?self $root = null;

    #[ORM\OneToMany(mappedBy: 'root', targetEntity: self::class)]
    private Collection $tree;

    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue('NONE')]
        #[ORM\Column]
        private ?int $id
    ) {
        $this->children = new ArrayCollection();
        $this->tree = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;
        $parent?->addChild($this);
        $this->setRoot($parent?->root ?: $parent);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getRoot(): ?self
    {
        return $this->root;
    }

    public function setRoot(?self $root): static
    {
        $this->root = $root;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getTree(): Collection
    {
        return $this->tree;
    }

    public function addTree(self $tree): static
    {
        if (!$this->tree->contains($tree)) {
            $this->tree->add($tree);
            $tree->setRoot($this);
        }

        return $this;
    }

    public function removeTree(self $tree): static
    {
        if ($this->tree->removeElement($tree)) {
            // set the owning side to null (unless already changed)
            if ($tree->getRoot() === $this) {
                $tree->setRoot(null);
            }
        }

        return $this;
    }
}
