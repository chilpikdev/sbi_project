<?php

namespace App\DTO;

abstract readonly class BaseIndexDto extends BaseDto
{
    /**
     * Summary of perPage
     * @var
     */
    public ?int $perPage;

    /**
     * Summary of page
     * @var
     */
    public ?int $page;

    /**
     * Summary of search
     * @var
     */
    public ?string $search;

    /**
     * Summary of orderBy
     * @var
     */
    public ?string $orderBy;

    /**
     * Summary of sort
     * @var
     */
    public ?string $sort;

    /**
     * Summary of PER_PAGE
     * @var int
     */
    const PER_PAGE = 10;

    /**
     * Summary of PAGE
     * @var int
     */
    const PAGE = 1;

    public function __construct(
        ?int $perPage,
        ?int $page,
        ?string $search,
        ?string $orderBy,
        ?string $sort,
    ) {
       $this->perPage = $perPage ?? self::PER_PAGE;
       $this->page = $page ?? self::PAGE;
       $this->search = $search;
       $this->orderBy = $orderBy;
       $this->sort = $sort;
    }
}
