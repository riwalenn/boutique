<?php

namespace App\Classe;

use App\Entity\Category;

class Search
{
    /**
     * @var string
     */
    public $string = '';

    /**
     * @var Category[]
     */
    public $categories = [];

    /**
     * @var string
     */
    public $shape = '';

    /**
     * @var int
     */
    public $minPrice = 0;

    /**
     * @var int
     */
    public $maxPrice = 0;
}