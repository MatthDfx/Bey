<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Picture::class, inversedBy: 'users')]
    private Collection $likeListPicture;

    #[ORM\ManyToMany(targetEntity: Video::class, inversedBy: 'users')]
    private Collection $likeListVideo;

    #[ORM\ManyToMany(targetEntity: Gif::class, inversedBy: 'users')]
    private Collection $likeListGif;

    public function __construct()
    {
        $this->likeListPicture = new ArrayCollection();
        $this->likeListVideo = new ArrayCollection();
        $this->likeListGif = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getLikeListPicture(): Collection
    {
        return $this->likeListPicture;
    }

    public function addLikeListPicture(Picture $likeListPicture): self
    {
        if (!$this->likeListPicture->contains($likeListPicture)) {
            $this->likeListPicture->add($likeListPicture);
        }

        return $this;
    }

    public function removeLikeListPicture(Picture $likeListPicture): self
    {
        $this->likeListPicture->removeElement($likeListPicture);

        return $this;
    }

    /**
     * @return Collection<int, Video>
     */
    public function getLikeListVideo(): Collection
    {
        return $this->likeListVideo;
    }

    public function addLikeListVideo(Video $likeListVideo): self
    {
        if (!$this->likeListVideo->contains($likeListVideo)) {
            $this->likeListVideo->add($likeListVideo);
        }

        return $this;
    }

    public function removeLikeListVideo(Video $likeListVideo): self
    {
        $this->likeListVideo->removeElement($likeListVideo);

        return $this;
    }

    /**
     * @return Collection<int, Gif>
     */
    public function getLikeListGif(): Collection
    {
        return $this->likeListGif;
    }

    public function addLikeListGif(Gif $likeListGif): self
    {
        if (!$this->likeListGif->contains($likeListGif)) {
            $this->likeListGif->add($likeListGif);
        }

        return $this;
    }

    public function removeLikeListGif(Gif $likeListGif): self
    {
        $this->likeListGif->removeElement($likeListGif);

        return $this;
    }
}
