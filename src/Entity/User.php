<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $firstname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lastname;

    // PlainPassword is a temporary field used to hold the plain password
    // during the registration process. It is then used to hash the password
    // and store it in the database.
    private $plainPassword;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isAccepted;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pseudo;

    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private $profilePhoto;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Course::class, cascade: ['persist'], orphanRemoval: true)]
    private $courses;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Section::class, cascade: ['persist'], orphanRemoval: true)]
    private $sections;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Lesson::class, cascade: ['persist'], orphanRemoval: true)]
    private $lessons;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Image::class, cascade: ['persist'], orphanRemoval: true)]
    private $images;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Document::class, cascade: ['persist'], orphanRemoval: true)]
    private $documents;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Tag::class)]
    private $tags;

    #[ORM\ManyToMany(targetEntity: Course::class, mappedBy: 'learners')]
    private $learnersCourses;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CourseProgressState::class)]
    private $courseProgressStates;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: SectionProgressState::class)]
    private $sectionProgressStates;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: LessonProgressState::class)]
    private $lessonProgressStates;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserProgressState::class)]
    private $userProgressStates;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Quiz::class)]
    private $quizzes;

    #[ORM\OneToMany(mappedBy: 'isResolvedBy', targetEntity: UserQuizResult::class)]
    private $userQuizResults;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->sections = new ArrayCollection();
        $this->lessons = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->learnersCourses = new ArrayCollection();
        $this->courseProgressStates = new ArrayCollection();
        $this->sectionProgressStates = new ArrayCollection();
        $this->lessonProgressStates = new ArrayCollection();
        $this->userProgressStates = new ArrayCollection();
        $this->quizzes = new ArrayCollection();
        $this->userQuizResults = new ArrayCollection();
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of plainPassword
     */ 
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getIsAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(?bool $isAccepted): self
    {
        $this->isAccepted = $isAccepted;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getProfilePhoto(): ?Image
    {
        return $this->profilePhoto;
    }

    public function setProfilePhoto(?Image $profilePhoto): self
    {
        $this->profilePhoto = $profilePhoto;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setUser($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getUser() === $this) {
                $course->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setUser($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getUser() === $this) {
                $image->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setUser($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getUser() === $this) {
                $document->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setUser($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getUser() === $this) {
                $section->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lesson>
     */
    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function addLesson(Lesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setUser($this);
        }

        return $this;
    }

    public function removeLesson(Lesson $lesson): self
    {
        if ($this->lessons->removeElement($lesson)) {
            // set the owning side to null (unless already changed)
            if ($lesson->getUser() === $this) {
                $lesson->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setUser($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            // set the owning side to null (unless already changed)
            if ($tag->getUser() === $this) {
                $tag->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getLearnersCourses(): Collection
    {
        return $this->learnersCourses;
    }

    public function addLearnersCourse(Course $learnersCourse): self
    {
        if (!$this->learnersCourses->contains($learnersCourse)) {
            $this->learnersCourses[] = $learnersCourse;
            $learnersCourse->addLearner($this);
        }

        return $this;
    }

    public function removeLearnersCourse(Course $learnersCourse): self
    {
        if ($this->learnersCourses->removeElement($learnersCourse)) {
            $learnersCourse->removeLearner($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, CourseProgressState>
     */
    public function getCourseProgressStates(): Collection
    {
        return $this->courseProgressStates;
    }

    public function addCourseProgressState(CourseProgressState $courseProgressState): self
    {
        if (!$this->courseProgressStates->contains($courseProgressState)) {
            $this->courseProgressStates[] = $courseProgressState;
            $courseProgressState->setUser($this);
        }

        return $this;
    }

    public function removeCourseProgressState(CourseProgressState $courseProgressState): self
    {
        if ($this->courseProgressStates->removeElement($courseProgressState)) {
            // set the owning side to null (unless already changed)
            if ($courseProgressState->getUser() === $this) {
                $courseProgressState->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SectionProgressState>
     */
    public function getSectionProgressStates(): Collection
    {
        return $this->sectionProgressStates;
    }

    public function addSectionProgressState(SectionProgressState $sectionProgressState): self
    {
        if (!$this->sectionProgressStates->contains($sectionProgressState)) {
            $this->sectionProgressStates[] = $sectionProgressState;
            $sectionProgressState->setUser($this);
        }

        return $this;
    }

    public function removeSectionProgressState(SectionProgressState $sectionProgressState): self
    {
        if ($this->sectionProgressStates->removeElement($sectionProgressState)) {
            // set the owning side to null (unless already changed)
            if ($sectionProgressState->getUser() === $this) {
                $sectionProgressState->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LessonProgressState>
     */
    public function getLessonProgressStates(): Collection
    {
        return $this->lessonProgressStates;
    }

    public function addLessonProgressState(LessonProgressState $lessonProgressState): self
    {
        if (!$this->lessonProgressStates->contains($lessonProgressState)) {
            $this->lessonProgressStates[] = $lessonProgressState;
            $lessonProgressState->setUser($this);
        }

        return $this;
    }

    public function removeLessonProgressState(LessonProgressState $lessonProgressState): self
    {
        if ($this->lessonProgressStates->removeElement($lessonProgressState)) {
            // set the owning side to null (unless already changed)
            if ($lessonProgressState->getUser() === $this) {
                $lessonProgressState->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserProgressState>
     */
    public function getUserProgressStates(): Collection
    {
        return $this->userProgressStates;
    }

    public function addUserProgressState(UserProgressState $userProgressState): self
    {
        if (!$this->userProgressStates->contains($userProgressState)) {
            $this->userProgressStates[] = $userProgressState;
            $userProgressState->setUser($this);
        }

        return $this;
    }

    public function removeUserProgressState(UserProgressState $userProgressState): self
    {
        if ($this->userProgressStates->removeElement($userProgressState)) {
            // set the owning side to null (unless already changed)
            if ($userProgressState->getUser() === $this) {
                $userProgressState->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes[] = $quiz;
            $quiz->setCreatedBy($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->quizzes->removeElement($quiz)) {
            // set the owning side to null (unless already changed)
            if ($quiz->getCreatedBy() === $this) {
                $quiz->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserQuizResult>
     */
    public function getUserQuizResults(): Collection
    {
        return $this->userQuizResults;
    }

    public function addUserQuizResult(UserQuizResult $userQuizResult): self
    {
        if (!$this->userQuizResults->contains($userQuizResult)) {
            $this->userQuizResults[] = $userQuizResult;
            $userQuizResult->setIsResolvedBy($this);
        }

        return $this;
    }

    public function removeUserQuizResult(UserQuizResult $userQuizResult): self
    {
        if ($this->userQuizResults->removeElement($userQuizResult)) {
            // set the owning side to null (unless already changed)
            if ($userQuizResult->getIsResolvedBy() === $this) {
                $userQuizResult->setIsResolvedBy(null);
            }
        }

        return $this;
    }
}
