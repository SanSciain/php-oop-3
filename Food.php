<?php
require_once __DIR__ . "/Product.php";
require_once __DIR__ . "/Expiring.php";

class Food extends Product
{
    use Expiring;
    public $type;

    public function __construct(
        $_name,
        $_price,
        $_expiring,
        $_type,
        $_availablity = "always"
    ) {
        parent::__construct($_name, $_price, $_availablity);
        $this->expiring = $_expiring;
        $this->type = $_type;
    }

    public function infos()
    {
        return $this->name . "<br> euro " . $this->price . "<br>available: " . $this->availablity . "<br>expering: " . $this->expiring . "<br>type: " . $this->type;
    }
}
