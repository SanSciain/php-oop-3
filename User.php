<?php
require_once __DIR__ . "/Expiring.php";

class User
{
    use Expiring;
    public $name;
    public $lastname;
    public $cart;
    public $registered;
    public $currentDate;

    public function __construct($_name, $_lastname, $_cardExpiring, $_currentDate, $_registered = false)
    {
        $this->name = $_name;
        $this->lastname = $_lastname;
        $this->expiring = $_cardExpiring;
        $this->registered = $_registered;
        $this->currentDate = $_currentDate;
    }

    public function addTo($_product)
    {
        $currentMonth = explode("-", $this->currentDate)[1];
        $months = explode("-", $_product->availablity);
        if ($_product->availablity === "always" || ($currentMonth >= $months[0] && $currentMonth <= $months[1])) {
            $this->cart[] = $_product;
        } else {
            throw new Exception("prodotto: " . $_product->name . " non disponibile in questo periodo");
        }
    }

    public function total()
    {
        $tot = 0;
        foreach ($this->cart as $obj) {
            $tot += $obj->price;
        }

        if ($this->registered === true) {
            $tot = $tot - $tot * 20 / 100;
        }

        return $tot;
    }

    public function faildPayment()
    {
        $isExpired = true;
        $continueFor = true;
        for ($i = 2; $i >= 0 && $continueFor; $i--) {
            $currentDate = explode("-", $this->currentDate)[$i];
            $cardDate = explode("-", $this->expiring)[$i];
            var_dump($currentDate);
            var_dump($cardDate);
            if ($currentDate < $cardDate) {
                $isExpired = false;
                $continueFor = false;
            } elseif ($currentDate === $cardDate) {
                $continueFor = true;
            } else {
                $isExpired = true;
                $continueFor = false;
            }
        }
        return $isExpired;
    }
}
