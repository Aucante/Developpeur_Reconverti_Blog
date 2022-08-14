<?php

namespace App\Entity;

use App\Repository\BlogPostLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogPostLikeRepository::class)
 */
class BlogPostLike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="blogPostLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=BlogPost::class, inversedBy="blogPostLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blogpost;

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

    public function getBlogpost(): ?BlogPost
    {
        return $this->blogpost;
    }

    public function setBlogpost(?BlogPost $blogpost): self
    {
        $this->blogpost = $blogpost;

        return $this;
    }
}
