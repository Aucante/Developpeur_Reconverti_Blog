<?php

namespace App\Entity;

use App\Repository\BlogPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogPostRepository::class)
 */
class BlogPost
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
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=BlogPostLike::class, mappedBy="blogpost", orphanRemoval=true)
     */
    private $blogPostLikes;

    public function __construct()
    {
        $this->blogPostLikes = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, BlogPostLike>
     */
    public function getBlogPostLikes(): Collection
    {
        return $this->blogPostLikes;
    }

    public function addBlogPostLike(BlogPostLike $blogPostLike): self
    {
        if (!$this->blogPostLikes->contains($blogPostLike)) {
            $this->blogPostLikes[] = $blogPostLike;
            $blogPostLike->setBlogpost($this);
        }

        return $this;
    }

    public function removeBlogPostLike(BlogPostLike $blogPostLike): self
    {
        if ($this->blogPostLikes->removeElement($blogPostLike)) {
            // set the owning side to null (unless already changed)
            if ($blogPostLike->getBlogpost() === $this) {
                $blogPostLike->setBlogpost(null);
            }
        }

        return $this;
    }
}
