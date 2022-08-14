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
     * @ORM\ManyToMany(targetEntity=BlogPost::class, inversedBy="categories")
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
     * @return Collection<int, BlogPost>
     */
    public function getBlogpost(): Collection
    {
        return $this->blogpost;
    }

    public function addBlogpost(BlogPost $blogpost): self
    {
        if (!$this->blogpost->contains($blogpost)) {
            $this->blogpost[] = $blogpost;
        }

        return $this;
    }

    public function removeBlogpost(BlogPost $blogpost): self
    {
        $this->blogpost->removeElement($blogpost);

        return $this;
    }
}
