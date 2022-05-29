<?php
    if(isset($_POST["grupa"]))
    {
        $plik = file($_POST["grupa"].".json");
        $wynik = $plik[filter_var($_POST["indeks"],FILTER_VALIDATE_INT)+1];
        echo str_replace("},","}",$wynik);
    }
    else
        echo "nie działa"
?>