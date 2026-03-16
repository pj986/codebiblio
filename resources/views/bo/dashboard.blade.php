<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<h1>Dashboard Bibliothèque</h1>

<hr>
<a href="/scanner" style="
display:inline-block;
padding:10px 15px;
background:#4CAF50;
color:white;
text-decoration:none;
border-radius:5px;
margin-bottom:20px;
">
📱 Scanner un livre
</a>

<h2>Statistiques générales</h2>

<ul>
<li><strong>Livres :</strong> {{ $livres }}</li>
<li><strong>Exemplaires :</strong> {{ $exemplaires }}</li>
<li><strong>Utilisateurs :</strong> {{ $users }}</li>
<li><strong>Emprunts en cours :</strong> {{ $empruntsEnCours }}</li>
</ul>

<hr>

<h2>Graphique des ressources</h2>

<canvas id="statsChart" width="400" height="200"></canvas>

<hr>

<h2>Top livres empruntés</h2>

<canvas id="livresChart" width="400" height="200"></canvas>

<br>

<a href="/bo/profils">Gestion utilisateurs</a>
<br>
<a href="/">Retour catalogue</a>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const statsCtx = document.getElementById('statsChart');

new Chart(statsCtx, {

    type: 'bar',

    data: {

        labels: ['Livres','Exemplaires','Utilisateurs','Emprunts'],

        datasets: [{

            label: 'Statistiques bibliothèque',

            data: [
                {{ $livres }},
                {{ $exemplaires }},
                {{ $users }},
                {{ $empruntsEnCours }}
            ]

        }]

    }

});


const livresCtx = document.getElementById('livresChart');

new Chart(livresCtx, {

    type: 'pie',

    data: {

        labels: [

            @foreach($topLivres as $livre)
                "{{ $livre->titre }}",
            @endforeach

        ],

        datasets: [{

            data: [

                @foreach($topLivres as $livre)
                    {{ $livre->total }},
                @endforeach

            ]

        }]

    }

});

</script>