<?php


class Paginator {
    private $totalItems;
    private $itemsPerPage;
    private $currentPage;

    public function __construct($totalItems, $itemsPerPage = 10, $currentPage = 1) {
        $this->totalItems = (int)$totalItems;
        $this->itemsPerPage = (int)$itemsPerPage;
        $this->currentPage = (int)$currentPage < 1 ? 1 : (int)$currentPage;
    }

    public function getOffset() {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    public function getLimit() {
        return $this->itemsPerPage;
    }

    public function getTotalPages() {
        return ceil($this->totalItems / $this->itemsPerPage);
    }

    public function hasNext() {
        return $this->currentPage < $this->getTotalPages();
    }

    public function hasPrev() {
        return $this->currentPage > 1;
    }

    public function getCurrentPage() {
        return $this->currentPage;
    }
}