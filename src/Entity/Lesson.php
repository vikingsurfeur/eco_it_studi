<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $video;

    #[ORM\Column(type: 'text')]
    private $explanation;

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'lessons')]
    private $section;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: Image::class, orphanRemoval: true)]
    private $imagesLesson;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: Document::class, orphanRemoval: true)]
    private $documentsLesson;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updatedAt;

    public function __construct()
    {
        $this->imagesLesson = new ArrayCollection();
        $this->documentsLesson = new ArrayCollection();
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

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): self
    {
        $this->explanation = $explanation;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImagesLesson(): Collection
    {
        return $this->imagesLesson;
    }

    public function addImagesLesson(Image $imagesLesson): self
    {
        if (!$this->imagesLesson->contains($imagesLesson)) {
            $this->imagesLesson[] = $imagesLesson;
            $imagesLesson->setLesson($this);
        }

        return $this;
    }

    public function removeImagesLesson(Image $imagesLesson): self
    {
        if ($this->imagesLesson->removeElement($imagesLesson)) {
            // set the owning side to null (unless already changed)
            if ($imagesLesson->getLesson() === $this) {
                $imagesLesson->setLesson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocumentsLesson(): Collection
    {
        return $this->documentsLesson;
    }

    public function addDocumentsLesson(Document $documentsLesson): self
    {
        if (!$this->documentsLesson->contains($documentsLesson)) {
            $this->documentsLesson[] = $documentsLesson;
            $documentsLesson->setLesson($this);
        }

        return $this;
    }

    public function removeDocumentsLesson(Document $documentsLesson): self
    {
        if ($this->documentsLesson->removeElement($documentsLesson)) {
            // set the owning side to null (unless already changed)
            if ($documentsLesson->getLesson() === $this) {
                $documentsLesson->setLesson(null);
            }
        }

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

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
