<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */

class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="parentId")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Categorie::class, mappedBy="categories")
     */
    private $parentId;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="categoryId", orphanRemoval=true)
     */
    private $articles;

    public function __construct()
    {
        $this->parentId = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategories(): ?self
    {
        return $this->categories;
    }

    public function setCategories(?self $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParentId(): Collection
    {
        return $this->parentId;
    }

    public function addParentId(self $parentId): self
    {
        if (!$this->parentId->contains($parentId)) {
            $this->parentId[] = $parentId;
            $parentId->setCategories($this);
        }

        return $this;
    }

    public function removeParentId(self $parentId): self
    {
        if ($this->parentId->removeElement($parentId)) {
            // set the owning side to null (unless already changed)
            if ($parentId->getCategories() === $this) {
                $parentId->setCategories(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategoryId($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategoryId() === $this) {
                $article->setCategoryId(null);
            }
        }

        return $this;
    }
}
