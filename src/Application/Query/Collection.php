<?php

namespace App\Application\Query;

use App\Domain\Common\ValueObject\AggregateRoot;

class Collection
{
    /**
     * @var int
     */
    public $from;

    /**
     * @var int
     */
    public $limit;

    /**
     * @var int
     */
    public $total;

    /**
     * @var AggregateRoot[]
     */
    public $data;

    public function __construct(int $from, int $limit, int $total, array $data)
    {
        $this->exists($from, $total);
        $this->from = $from;
        $this->limit = $limit;
        $this->total = $total;
        $this->data = $data;
    }

    private function exists(int $from, int $total): void
    {
        if ($from >= $total && $total > 0) {
            throw new \InvalidArgumentException();
        }
    }
}
