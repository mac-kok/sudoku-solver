<?php

abstract class Set
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var array<Cell>
     */
    protected $cells = [];

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return array<Cell>
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * @param Cell $cell
     */
    public function addCell($cell)
    {
        $this->cells[] = $cell;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}