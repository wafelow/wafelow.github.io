<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria zdjęć</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Galeria zdjęć</h1>
    </header>
    <div id="wybor">
        <?php
            foreach (glob("obrazy/*.json") as $grupa) {
                ?>
                    <button type="button" id="<?php echo str_replace(".json","",$grupa);?>">
                        <?php echo str_replace([".json","obrazy/"],"",$grupa);?>
                    </button>
                <?php
            }
        ?>
    </div>
    <div id="obraz_grupa">
        <h3 id="obraz_sekcja_nazwa">Wybierz sekcję</h3>
        <h5 id="obraz_nazwa"></h5>
        <img id="obraz"  alt="Tu pojawi się obraz">
        <div id="obraz_nawigacja">
            <button id="obraz_poprzedni">Poprzedni obraz</button>
            <button id="obraz_nastepny">Następny obraz</button>
        </div>
        
    </div>
    <footer>Autor: Michał Szelest</footer>
    <script>
        let obraz_indeks = 0;
        let obraz_indeks_poprzedni = 0;
        function button_wybor(button_nazwa)
        {
            return function()
            {
                obraz_indeks = 0;
                document.getElementById("obraz_sekcja_nazwa").innerText = button_nazwa;
                document.getElementById("obraz_nawigacja").style.display = "flex";
                nowy_obraz(button_nazwa,obraz_indeks)
                document.getElementById("obraz_nastepny").onclick = ()=> nowy_obraz(button_nazwa,obraz_indeks+1)
                document.getElementById("obraz_poprzedni").onclick = ()=> nowy_obraz(button_nazwa,obraz_indeks-1)
            }
        }
        function nowy_obraz(grupa,indeks)
        {
            let formularz = new FormData();
            formularz.append("indeks",indeks);
            formularz.append("grupa",grupa)
            fetch("./obrazy/index.php",
                {
                    method:"POST",
                    body:formularz,
                    redirect: 'follow',
                    
                })
            .then((wynik)=>wynik.json())
            .then(function(wynik)
            {
                
                document.getElementById("obraz_nazwa").innerText = wynik.name;
                document.getElementById("obraz").setAttribute("src",wynik.path.replace("\\\\","\\"))
                obraz_indeks = indeks;
            })
            .catch()
        }
        document.querySelectorAll("#wybor button").forEach(
            (button) =>button.onclick = button_wybor(button.innerText)
        )
    </script>
</body>
</html>