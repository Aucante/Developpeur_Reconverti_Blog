<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=BlogPost::class, mappedBy="categories")
     */
    private $blogpost;

    public function __construct()
    {
        $this->blogpost = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getBlogPost(): Collection
    {
        return $this->blogpost;
    }

    public function addBlogPost(BlogPost $blogpost): self
    {
        if (!$this->blogpost->contains($blogpost)) {
            $this->blogpost[] = $blogpost;
            $blogpost->setCategory($this);
        }

        return $this;
    }

    public function removeBlogPost(BlogPost $blogPost): self
    {
        if ($this->blogpost->contains($blogPost)) {
            $this->blogpost->removeElement($blogPost);
            // set the owning side to null (unless already changed)
            if ($blogPost->getCategory() === $this) {
                $blogPost->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

}
