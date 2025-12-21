

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMMAND</title>
    <link rel="stylesheet" href="/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/Views/command/read.css">
    <nav class="navbarAll">
        <div>
          <a class="logo">VENTE</a>
          
          <div class="" id="mynavbar">
           
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
                   <a href="index.php?entity=client&action=read"><button class="nav-link">Clients</button></a>
                </li>
                 <li class="nav-item">
                   <a href="index.php?entity=reglement&action=read"><button class="nav-link">Reglements</button></a>
                </li>
                 <li class="nav-item">
                   <a href="index.php?entity=command&action=read"><button class="nav-link">Commandes</button></a>
                </li>
            <form class="d-flex" action="index.php?entity=achat&action=rechercher" method="POST" >
              <input id="inputRecherche" name="inputRecherche" type="text" placeholder="Taper ici pour rechercher">
              <button class="btnRecherche" type="submit" >Rechercher</button>
            </form>
          <a href=""><button class="notif">N</button></a>
            
          </div>
        </div>
      </nav>
</head>
<body>
    
<div class="titre">
        <h1>Liste des commandes</h1>
    </div>
    <div  style="margin-top: 55px;"><br><br><br>
        <div class="teste">
    
        </div>
        <br><br>
        
        <table class="tbl" id="AchatsVidy">
          
            <colgroup>
                <col style="width: 200px;">
                <col style="width: 200px;">
                <col style="width: 200px;">
                <col style="width: 200px;">
                <col style="width: 250px;">

            
            </colgroup>
            
            <thead  style="position: fixed;">
                <tr class="trMedocTble">
                    <th style="width: 200px;">Numero de commande</th>
                    <th style="width: 200px;">Nom de client </th>
                    <th style="width: 200px;">Date de commande</th>
                    <th style="width: 200px;">Statut</th>
                    <th style="width: 345px; background-color:rgb(33, 33, 33);color: white;">Action</th>
                </tr>
            </thead>
            <tr style="height: 40px;"></tr>

              <tbody>

              <?php foreach ($command as $command) : ?>
              <tr>
                  <td> <?= $command['num_bon_commande'] ?></td>
                  <td> <?= $command['nom_client'] ?></td>
                  <td> <?= $command['date_commande'] ?></td>
                  <td> <?= $command['statut'] ?></td>
                  <td style="display: flex;justify-content: flex-start; align-items: center;  gap: 10px;  margin-left: 15px">

                      <form id="formAchat" method="post" action="index.php?entity=command&action=CreatePdf&id=<?= $command['num_bon_commande'] ?>"> 
                        <button type="submit" name="genererPdf" style="background-color: rgb(193, 215, 251); border: 2px solid darkblue;" id="Edit"> Editer en pdf</button> 
                      </form>
                        <button style="background-color: rgb(255, 189, 189); border: 2px solid rgb(158, 3, 3);" class="btnSupprimer" data-id="<?= $command['num_bon_commande'] ?>">Supprimer</button>
                        <button onclick = "openModal1('<?= $command['num_bon_commande']?>','<?= $command['nom_client'] ?>','<?= $command['date_commande']?>','<?= $command['statut'] ?>')" style="background-color: rgb(223, 209, 26); border: 2px solid darkblue;" id="Edit"> Modifier</button> 
                                    
                  </td>
              </tr>
              <?php endforeach; ?>

              </tbody>
          
        </table>
        <div><a href="index.php?entity=command&action=create" ><button class="btn1">Ajouter</button></a></div>
        <!-- <div><button class="ExporPdf">Exporter en pdf</button></div> -->
    </div>

    <div class="">

    </div>

    <div id="modal1" class="modal1">
            <div class="modal-content1">
                <span class="close" onclick="closeModal1()">&times;</span>
                <h2>Modification de commande</h2>
                <form id="command-form" action="index.php?entity=command&action=update" method="POST">

                    <label for="dateAchat">Date de commande :</label>
                    <input type="date" name="date_cmd" id="dateAchat">

                    <label for="nomClient">Nom client :</label>
                    <input type="text" name="nom_client" id="nomClient" value="" >
                  
                    <label for="statut1">Statut:</label>
                    <select name="statut" id="statut1">
                        <option value="En attente">En attente</option>
                        <option value="Regle">Regle</option>
                    </select>

                    <button type="submit" class="btn2">Enregistrer</button>
                </form>
            </div>
    </div>
    <script>
        // Fonction pour ouvrir la boîte modal

        function openModal1(num_bon_commande, nomClient, date_cmd , statut) {
            document.getElementById('nomClient').value = nomClient;
            document.getElementById('dateAchat').value = date_cmd;
            document.getElementById('statut1').value = statut;
            const form = document.getElementById('command-form');
            form.action = `index.php?entity=command&action=update&id=${num_bon_commande}`;
            document.getElementById("modal1").style.display = "flex";

        }


        // Fonction pour fermer la boîte modale

        function closeModal1() {
            document.getElementById("modal1").style.display = "none";
        }

        window.onclick = function(event) {
            const modal1 = document.getElementById('modal1');

            if(event.target === modal1) {
                modal1.style.display = "none";
            } 

        };
    </script>

    <script src="/lib/sweetalert2/sweetalert2.all.min.js" ></script>
    <script src="/Views/command/script.js"></script>
    
    
</body>
</html>

 