<?php

class Cell
{
    private $id;
    private $number = 0;
    private $row;
    private $column;
    private $block;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return Row
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @return Column
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @return Block
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param Row $row
     */
    public function setRow($row)
    {
        $this->row = $row;
    }

    /**
     * @param Column $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    /**
     * @param Block $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}