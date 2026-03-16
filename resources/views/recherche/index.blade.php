<h1>Recherche de livres</h1>

<div style="width:400px;position:relative">

<input 
    type="text" 
    id="search" 
    placeholder="Rechercher un livre..."
    style="width:100%;padding:10px;font-size:16px"
>

<div id="results" style="
    position:absolute;
    background:white;
    border:1px solid #ccc;
    width:100%;
    display:none;
"></div>

</div>

<script>

const input = document.getElementById("search");
const results = document.getElementById("results");

input.addEventListener("keyup", function(){

    const query = input.value;

    if(query.length < 2){

        results.style.display = "block";
        results.innerHTML = "<div style='padding:10px'>Tapez au moins 2 caractères</div>";
        return;

    }

    fetch("/bo/api/recherche-livres?q=" + query)

    .then(response => response.json())

    .then(data => {

        results.innerHTML = "";

        if(data.length === 0){

            results.style.display = "block";
            results.innerHTML = "<div style='padding:10px'>Aucun livre trouvé</div>";
            return;

        }

        results.style.display = "block";

        data.forEach(livre => {

            const div = document.createElement("div");

            div.style.padding = "10px";
            div.style.cursor = "pointer";
            div.style.borderBottom = "1px solid #eee";

            div.innerHTML =
                "<strong>" + livre.titre + "</strong><br>" +
                "<small>Auteur : " + livre.auteur + "</small>";

            div.addEventListener("mouseover", function(){

                div.style.background = "#f3f3f3";

            });

            div.addEventListener("mouseout", function(){

                div.style.background = "white";

            });

            results.appendChild(div);

        });

    });

});

// fermer si on clique ailleurs

document.addEventListener("click", function(e){

    if(!input.contains(e.target)){

        results.style.display = "none";

    }

});

</script>