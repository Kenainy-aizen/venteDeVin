<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLIENT</title>
    <link rel="stylesheet" href="/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/Views/client/read.css">
    <nav class="navbarAll">
        <div>
          <a class="logo">VENTE</a>
          
          <div class="" id="mynavbar">
            <ul>
              <li class="nav-item">
                <a href="index.php?entity=acceuil&action=read"><button class="nav-link">Dashbord</button></a>
              </li>
              <li class="nav-item">
                <a href="index.php?entity=produit&action=read"><button class="nav-link" >Produit</button></a>
              </li>
              <li class="nav-item">
                <a href="index.php?entity=achat&action=read"><button class="nav-link">Achats</button></a>
              </li>
              <li class="nav-item">
                <a href="index.php?entity=client&action=read"><button class="nav-link">Client</button></a>
              </li>
              <li class="nav-item">
                <a href="index.php?entity=reglement&action=read"><button class="nav-link">Reglement</button></a>
              </li> 
               <li class="nav-item">
                   <a href="index.php?entity=command&action=read"><button class="nav-link">Commande</button></a>
                </li>            
            </ul>
            <!-- <form class="d-flex" action="">
              <input id="inputRecherche" type="text" placeholder="Taper ici pour rechercher">
              <button class="btnRecherche">Rechercher</button>
            </form> -->
            <!-- <a href=""><button class="notif">N</button></a> -->
            
          </div>
        </div>
      </nav>
</head>
<body>
<div class="titre">
        <h1>Liste des clients</h1>
    </div>
    <div  style="margin-top: 55px;"><br><br><br>     
        
        <table style="margin-left: 82px;" class="tbl" id="enter">
            <colgroup>
                <col style="width: 200px;">
                <col style="width: 200px;">
                <col style="width: 200px;">
                <col style="width: 200px;">
                <col style="width: 200px;">
                <col style="width: 200px;">
                
            </colgroup>
            <thead style="position: fixed;">
                <tr class="trMedocTble">
                    <th style="width: 200px;">Numero </th>
                    <th style="width: 200px;">Nom </th>
                    <th style="width: 200px;">Type </th>
                    <th style="width: 200px;">Adresse</th>
                    <th style="width: 200px;">Telephone</th>
                    <th style="width: 200px;">Email</th>
                    <th style="width: 210px; background-color:rgb(33, 33, 33);color: white;">Action</th>
                </tr>
            </thead>
            <tr style="height: 40px;"></tr>
            <tbody>

              <?php foreach ($client as $client) : ?>
              <tr>
                  <td> <?= $client['num_client'] ?></td>
                  <td> <?= $client['nom_client'] ?></td>
                  <td> <?= $client['type_client'] ?></td>
                  <td> <?= $client['adresse_client'] ?></td>
                  <td> <?= $client['telephone_client'] ?></td>
                  <td> <?= $client['email_client'] ?></td>
                  <td>
                      <button onclick="openModal1('<?= $client['num_client'] ?>', '<?= $client['nom_client'] ?>', '<?= $client['type_client'] ?>', '<?= $client['adresse_client'] ?>','<?= $client['telephone_client'] ?>','<?= $client['email_client'] ?>')" style="background-color: rgb(193, 215, 251); border: 2px solid darkblue;" id="Edit">Editer</button>
                      <button style="background-color: rgb(255, 189, 189); border: 2px solid rgb(158, 3, 3);" class="btnSupprimer" data-id="<?= $client['num_client'] ?>">Supprimer</button>
                        
                  </td>
              </tr>
              <?php endforeach; ?>

            </tbody>
            
        </table>

        <button onclick = "openModal()" class="btn1">Ajouter</button>
    </div>

    <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Ajouter un client</h2>
                <form action="index.php?entity=client&action=create" method="POST">
                    <label for="nom_client">Nom :</label>
                    <input type="text" name="nom_client" id="nom_client" required>
                    <label for="type_client">Type client :</label>
                    <select name="type_client" id="type_client">
                        <option value="Detaillant">Detaillant</option>
                        <option value="Consommateur">Consommateur</option>
                        <option value="Grossiste">Grossiste</option>
                    </select>
                    <label for="adresse">Adresse :</label>
                    <input type="text" name="adresse" id="adresse">
                    <label for="telephone">Telephone :</label>
                    <input type="number" id="telephone" name="telephone">
                    <label for="email">Email :</label>
                    <input type="text" id="email" name="email">
                    <button type="submit" class="btn">Enregistrer</button>
                </form>
            </div>
    </div>

    <div id="modal1" class="modal1">
            <div class="modal-content1">
                <span class="close" onclick="closeModal1()">&times;</span>
                <h2>Modification un client</h2>
                <form id="client-form" action="index.php?entity=client&action=update" method="POST">
                    <label for="nom_client1">Nom :</label>
                    <input type="text" name="nom_client1" id="nom_client1">
                    <label for="type_client1">Type :</label>
                    <select name="type_client1" id="type_client1">
                        <option value="Detaillant">Detaillant</option>
                        <option value="Consommateur">Consommateur</option>
                        <option value="Grossiste">Grossiste</option>
                    </select>
                    <label for="adresse1">Adresse :</label>
                    <input type="text" name="adresse1" id="adresse1">
                    <label for="telephone1">Telephone :</label>
                    <input type="text" name="telephone1" id="telephone1">
                    <label for="email1">Email :</label>
                    <input type="text" name="email1" id="email1">
                    <button type="submit" class="btn2">Enregistrer</button>
                </form>
            </div>
    </div> 

    <script>
        // Fonction pour ouvrir la boîte modale
        function openModal() {
            document.getElementById("modal").style.display = "flex";
        }

        function openModal1(num_client, nom_client, type_client, adresse, telephone, email) {
         //   document.getElementById('num_client1').value = num_client;
            document.getElementById('nom_client1').value = nom_client;
            document.getElementById('type_client1').value = type_client;
            document.getElementById('adresse1').value = adresse;
            document.getElementById('telephone1').value = telephone;
            document.getElementById('email1').value = email;

            const form = document.getElementById('client-form');
            form.action = `index.php?entity=client&action=update&id=${num_client}`;

            document.getElementById("modal1").style.display = "flex";
          
        }


        // Fonction pour fermer la boîte modale
        function closeModal() {
            document.getElementById("modal").style.display = "none";
        }

        function closeModal1() {
            document.getElementById("modal1").style.display = "none";
        }

        window.onclick = function(event) {
            const modal1 = document.getElementById('modal1');
            const modal = document.getElementById('modal');
            if(event.target === modal1) {
                modal1.style.display = "none";
            } else if(event.target == modal) {
                modal.style.display = "none";
            }
        };
        
    </script>

    <script src="/lib/sweetalert2/sweetalert2.all.min.js" ></script>
    <script src="/Views/client/script.js"></script>
       

</body>
</html>