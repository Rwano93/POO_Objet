<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil Utilisateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        h1 {
            text-align: center;
        }
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .actions {
            display: flex;
            justify-content: space-around;
        }
        .search-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        #searchInput {
            border-radius: 15px;
        }
        .btn-small {
            padding: 5px 10px;
            font-size: 0.875rem;
        }
    </style>
    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("userTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Page d'Utilisateur</h1>
        <div class="search-container">
            <button onclick="location.href='ajouter_utilisateur.html'" class="btn btn-primary btn-small">Ajouter</button>
            <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Rechercher" class="form-control">
            <button onclick="location.href='admin.html'" class="btn btn-secondary btn-small">Retour</button>
        </div>
        <table id="userTable">
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Mot de passe</th>
                <th>Actions</th>
            </tr>
            <?php
            $bdd = new PDO('mysql:host=localhost;dbname=poo;charset=utf8', 'root', '');
            $reponse = $bdd->query('SELECT * FROM user');
            while ($donnees = $reponse->fetch()) {
                echo '<tr>';
                echo '<td>' . $donnees['id_user'] . '</td>';
                echo '<td>' . $donnees['username'] . '</td>';
                echo '<td>' . $donnees['email'] . '</td>';
                echo '<td>' . $donnees['password'] . '</td>';
                echo '<td class="actions">';
                echo '<button onclick="location.href=\'modifier_utilisateur?id=' . $donnees['id_user'] . '\'" class="btn btn-primary">Modifier</button>';
                echo '<button onclick="location.href=\'supprimer_utilisateur.html?id=' . $donnees['id_user'] . '\'" class="btn btn-danger">Supprimer</button>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</body>
</html>