<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Unique()
     * @Assert\NotBlank(message="Upload image as jpg/png")
     * @Assert\File(maxSize="128M", mimeTypes={"image/png", "image/jpeg", "image/jpg"})
     */
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity=Record::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $record;

    public function __toString()
    {
        return $this->filename;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getRecord(): ?Record
    {
        return $this->record;
    }

    public function setRecord(?Record $record): self
    {
        $this->record = $record;

        return $this;
    }
}
