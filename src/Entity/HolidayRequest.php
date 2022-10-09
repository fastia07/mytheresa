<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 */
class HolidayRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Worker::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status = 'pending';

    /**
     * @ORM\OneToOne(targetEntity=Manager::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="resolved_by", referencedColumnName="id")
     */
    private $resolved_by;

    /**
     * @ORM\Column(type="datetime")
     */
    private $request_created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $vacation_start_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $vacation_end_date;

    public function __construct()
    {
        $this->request_created_at = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?Worker
    {
        return $this->author;
    }

    public function setAuthor(?Worker $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getResolvedBy(): ?Manager
    {
        return $this->resolved_by;
    }

    public function setResolvedBy(?Manager $resolved_by): self
    {
        $this->resolved_by = $resolved_by;

        return $this;
    }

    public function getRequestCreatedAt(): ?\DateTimeInterface
    {
        return $this->request_created_at;
    }

    public function setRequestCreatedAt(\DateTimeInterface $request_created_at): self
    {
        $this->request_created_at = $request_created_at;

        return $this;
    }

    public function getVacationStartDate(): ?\DateTimeInterface
    {
        return $this->vacation_start_date;
    }

    public function setVacationStartDate(\DateTimeInterface $vacation_start_date): self
    {
        $this->vacation_start_date = $vacation_start_date;

        return $this;
    }

    public function getVacationEndDate(): ?\DateTimeInterface
    {
        return $this->vacation_end_date;
    }

    public function setVacationEndDate(\DateTimeInterface $vacation_end_date): self
    {
        $this->vacation_end_date = $vacation_end_date;

        return $this;
    }

    public function validateVacationDate(): bool
    {
        return $this->getVacationStartDate() > $this->getVacationEndDate();
    }
}
