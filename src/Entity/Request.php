<?php

namespace App\Entity;

use App\Repository\RequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestRepository::class)
 */
class Request
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?int
    {
        return $this->author;
    }

    public function setAuthor(int $author): self
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

    public function getResolvedBy(): ?int
    {
        return $this->resolved_by;
    }

    public function setResolvedBy(int $resolved_by): self
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
}
