<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Utilisateurs</title>

<style>

body {
    font-family: Arial;
    margin: 0;
    background: #f4f6f9;
    transition: 0.3s;
}

.dark {
    background: #1e1e2f;
    color: white;
}

header {
    background: #2c3e50;
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
}

.container {
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
}

th {
    background: #eee;
}

.dark th {
    background: #333;
}

tr:hover {
    background: #f9f9f9;
}

.dark tr:hover {
    background: #2a2a3a;
}

.badge-admin {
    background: #3498db;
    color: white;
    padding: 4px 8px;
    border-radius: 5px;
}

.badge-user {
    background: #bdc3c7;
    color: white;
    padding: 4px 8px;
    border-radius: 5px;
}

.btn {
    padding: 5px 8px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.delete { background: #e74c3c; color: white; }
.reset { background: #f39c12; color: white; }
.unblock { background: #2ecc71; color: white; }
.toggle { background: #8e44ad; color: white; }

.search {
    padding: 8px;
    width: 250px;
}

</style>

<script>
function toggleDark(){
    let body = document.body;
    body.classList.toggle("dark");
    localStorage.setItem("dark", body.classList.contains("dark"));
}

if(localStorage.getItem("dark") === "true"){
    document.body.classList.add("dark");
}
</script>

</head>

<body>

<header>
    <h2>👥 Admin - Utilisateurs</h2>
    <button onclick="toggleDark()">🌙</button>
</header>

<div class="container">

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

<!-- 🔎 RECHERCHE + FILTRES -->
<form method="GET" style="margin-bottom:15px;">

    <input class="search" name="search" placeholder="Rechercher..." value="{{ request('search') }}">

    <select name="role">
        <option value="">Tous rôles</option>
        <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
        <option value="user" {{ request('role')=='user'?'selected':'' }}>User</option>
    </select>

    <select name="blocked">
        <option value="">Statut</option>
        <option value="1" {{ request('blocked')==='1'?'selected':'' }}>Bloqué</option>
        <option value="0" {{ request('blocked')==='0'?'selected':'' }}>Actif</option>
    </select>

    <button>Filtrer</button>

</form>

<!-- 📥 EXPORT CSV -->
<div style="margin-bottom:10px;">
    <a href="/bo/profils/export/csv">📥 Export CSV</a>
</div>

<!-- 🔀 TRI -->
<p>
    Trier :
    <a href="?sort=id&dir=asc">ID ↑</a> |
    <a href="?sort=id&dir=desc">ID ↓</a> |
    <a href="?sort=name&dir=asc">Nom</a>
</p>

<table>

<tr>
<th>ID</th>
<th>Nom</th>
<th>Email</th>
<th>Rôle</th>
<th>Emprunts</th>
<th>Statut</th>
<th>Actions</th>
</tr>

@foreach($users as $user)

<tr>

<td>{{ $user->id }}</td>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>

<td>
@if($user->role === 'admin')
<span class="badge-admin">ADMIN</span>
@else
<span class="badge-user">USER</span>
@endif
</td>

<td>{{ $user->emprunts_count }}</td>

<td>
@if($user->is_blocked)
<span style="color:red;font-weight:bold;">Bloqué</span>
@else
<span style="color:green;">Actif</span>
@endif
</td>

<td>

<!-- 🔁 TOGGLE ADMIN -->
<form method="POST" action="/bo/profils/{{ $user->id }}/toggle-admin" style="display:inline">
@csrf
<button class="btn toggle">
@if($user->role === 'admin')
Retirer admin
@else
Passer admin
@endif
</button>
</form>

<!-- 🔁 RESET -->
<form method="POST" action="/bo/profils/{{ $user->id }}/reset-password" style="display:inline">
@csrf
<button class="btn reset">Reset</button>
</form>

<!-- ❌ DELETE -->
<form method="POST" action="/bo/profils/{{ $user->id }}" style="display:inline">
@csrf
@method('DELETE')
<button class="btn delete">Supprimer</button>
</form>

<!-- 🔓 UNBLOCK -->
@if($user->is_blocked)
<form method="POST" action="/bo/profils/{{ $user->id }}/unblock" style="display:inline">
@csrf
<button class="btn unblock">Débloquer</button>
</form>
@endif

</td>

</tr>

@endforeach

</table>

<!-- 📄 PAGINATION -->
<div style="margin-top:20px;">
    {{ $users->links() }}
</div>

<br>

<a href="/bo/dashboard">⬅ Dashboard</a> |
<a href="/bo/logs">📜 Logs</a> |
<a href="/">🏠 Site</a>

</div>

</body>
</html>