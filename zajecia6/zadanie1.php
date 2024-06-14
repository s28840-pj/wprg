<?php

class NoweAuto {
    protected $model;
    protected $cenaEuro;
    protected $kursEuroPLN;

    public function __construct($model, $cenaEuro, $kursEuroPLN) {
        $this->model = $model;
        $this->cenaEuro = $cenaEuro;
        $this->kursEuroPLN = $kursEuroPLN;
    }

    public function ObliczCene() {
        return $this->cenaEuro * $this->kursEuroPLN;
    }

    public function getModel() {
        return $this->model;
    }

    public function getCenaEuro() {
        return $this->cenaEuro;
    }

    public function getKursEuroPLN() {
        return $this->kursEuroPLN;
    }
}

class AutoZDodatkami extends NoweAuto {
    private $alarm;
    private $radio;
    private $klimatyzacja;

    public function __construct($model, $cenaEuro, $kursEuroPLN, $alarm, $radio, $klimatyzacja) {
        parent::__construct($model, $cenaEuro, $kursEuroPLN);
        $this->alarm = $alarm;
        $this->radio = $radio;
        $this->klimatyzacja = $klimatyzacja;
    }

    public function ObliczCene() {
        $cenaPodstawowaPLN = parent::ObliczCene();
        $cenaDodatkow = $this->alarm + $this->radio + $this->klimatyzacja;
        return $cenaPodstawowaPLN + $cenaDodatkow;
    }

    public function getAlarm() {
        return $this->alarm;
    }

    public function getRadio() {
        return $this->radio;
    }

    public function getKlimatyzacja() {
        return $this->klimatyzacja;
    }
}

class Ubezpieczenie extends AutoZDodatkami {
    private $procentowaWartoscUbezpieczenia;
    private $liczbaLatPosiadania;

    public function __construct($model, $cenaEuro, $kursEuroPLN, $alarm, $radio, $klimatyzacja, $procentowaWartoscUbezpieczenia, $liczbaLatPosiadania) {
        parent::__construct($model, $cenaEuro, $kursEuroPLN, $alarm, $radio, $klimatyzacja);
        $this->procentowaWartoscUbezpieczenia = $procentowaWartoscUbezpieczenia;
        $this->liczbaLatPosiadania = $liczbaLatPosiadania;
    }

    public function ObliczCene() {
        $cenaSamochoduZDodatkami = parent::ObliczCene();
        $procentPomniejszenia = (100 - $this->liczbaLatPosiadania) / 100;
        $wartoscUbezpieczenia = $this->procentowaWartoscUbezpieczenia * $cenaSamochoduZDodatkami * $procentPomniejszenia;
        return $cenaSamochoduZDodatkami + $wartoscUbezpieczenia;
    }

    public function getProcentowaWartoscUbezpieczenia() {
        return $this->procentowaWartoscUbezpieczenia;
    }

    public function getLiczbaLatPosiadania() {
        return $this->liczbaLatPosiadania;
    }
}

$noweAuto = new NoweAuto("Model X", 50000, 4.5);
echo "Cena NoweAuto: " . $noweAuto->ObliczCene() . " PLN<br>";

$autoZDodatkami = new AutoZDodatkami("Model Y", 60000, 4.5, 1000, 1500, 2000);
echo "Cena AutoZDodatkami: " . $autoZDodatkami->ObliczCene() . " PLN<br>";

$ubezpieczenie = new Ubezpieczenie("Model Z", 70000, 4.5, 1200, 1600, 2200, 0.05, 3);
echo "Cena Ubezpieczenie: " . $ubezpieczenie->ObliczCene() . " PLN<br>";
