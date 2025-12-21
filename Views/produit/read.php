<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRODUIT</title>
    <link rel="stylesheet" href="/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/Views/produit/read.css">
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
                  <a href="index.php?entity=client&action=read"><button class="nav-link">Clients</button></a>
                </li>  
                <li class="nav-item">
                  <a href="index.php?entity=reglement&action=read"><button class="nav-link">Reglement</button></a>
                </li>  
                 <li class="nav-item">
                   <a href="index.php?entity=command&action=read"><button class="nav-link">Commande</button></a>
                </li> 
              </ul>
            <form class="d-flex" action="index.php?entity=medicament&action=rechercher" method="POST">
              <input id="inputRecherche" name="design" type="text" placeholder="Taper ici pour rechercher">
              <button class="btnRecherche" type="submit">Rechercher</button>
            </form>
          <a href=""><button class="notif">N</button></a>
            
          </div>
        </div>
      </nav>
</head>
<body>
    
    
    <div class="titre">
        <h1>Liste des produit </h1>
    </div>
    <div  style="margin-top: 55px;"><br><br><br>     
            
            <table  class="tbl" id="medicaments">
             
                <colgroup>
                    <col style="width: 170px;">
                    <col style="width: 170px;">
                    <col style="width: 170px;">
                    <col style="width: 170px;">
                    
                </colgroup>
                <thead style="position: fixed; ">
                       
                    <tr class="trMedocTble">
                        <th style="width: 170px;">Numero de produit</th>
                        <th style="width: 250px;">Designation</th>
                        <th style="width: 170px;">Nombre de stock</th>
                        <th style="width: 170px;">Prix detaillant</th>
                        <th style="width: 170px;">Prix de gros</th>
                        <th style="width: 170px;">Prix consommateur</th>
                        <th style="width: 210px; background-color:rgb(33, 33, 33);color: white;">Action</th>
                    </tr>
                </thead>
                <tr style="height: 40px;"></tr>
               <tbody>

                <?php foreach ($produit as $produit) : ?>
                <tr>
                    <td style="width: 170px;"> <?= $produit['num_produit'] ?></td>
                    <td style="width: 250px;text-align: left;"> <?= $produit['design'] ?></td>
                    <td style="width: 170px;"> <?= $produit['nombre'] ?></td>
                    <td style="width: 170px;"> <?= $produit['prix_detaillant'] ?></td>
                    <td style="width: 170px;"> <?= $produit['prix_consommateur'] ?></td>
                    <td style="width: 170px;"> <?= $produit['prix_gros'] ?></td>
                    <td>
                        <button onclick="openModal1('<?= $produit['num_produit'] ?>', '<?= $produit['design'] ?>', '<?= $produit['prix_detaillant'] ?>', '<?= $produit['prix_consommateur']?>','<?= $produit['prix_gros']?>','<?= $produit['nombre'] ?>')" style="background-color: rgb(193, 215, 251); border: 2px solid darkblue;" id="Edit">Editer</button>
                        <!-- <a href="index.php?entity=medicament&action=delete&id="><button style="background-color: rgb(255, 189, 189); border: 2px solid rgb(158, 3, 3);" id="Delete">Supprimer</button></a> -->
                        <!-- <button style="background-color: rgb(255, 189, 189); border: 2px solid rgb(158, 3, 3);" class="delete-btn" id="Delete" data-id="">Supprimer</button> -->
                        <button style="background-color: rgb(255, 189, 189); border: 2px solid rgb(158, 3, 3);" class="btnSupprimer" data-id="<?= $produit['num_produit'] ?>">Supprimer</button>
                        
                    </td>
                </tr>
                <?php endforeach; ?>
               
               </tbody>
                
            </table>

    </div>

    <button id="btn1" onclick="openModal()">Ajouter</button>

    <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Ajouter un produit</h2>
                <form id="produit-form" method="POST">
                    <label for="design">Désignation :</label>
                    <input type="text" name="design" id="design" required>

                    <label for="prix_consommateur">Prix consommateur :</label>
                    <input type="number" name="prix_consommateur" id="prix_consommateur" required> 

                    <label for="prix_detaillant">Prix detaillant :</label>
                    <input type="number" name="prix_detaillant" id="prix_detaillant" required> 

                    <label for="prix_consommateur">Prix de gros :</label>
                    <input type="number" name="prix_gros" id="prix_gros" required> 

                    <label for="nombre">Nombre :</label>
                    <input type="number" name="nombre" id="nombre" required> 

                    <button type="submit" class="btn">Enregistrer</button>
                </form>
            </div>
    </div>

    <div id="modal1" class="modal1">
            <div class="modal-content1">
                <span class="close" onclick="closeModal1()">&times;</span>
                <h2>Modification un produit</h2>
                <form id="medicament-form1" method="POST">
                    <label for="design1">Désignation :</label>
                    <input type="text" name="design1" id="design1" value="" >
                    <label for="prix_detaillant1">Prix detaillant :</label>
                    <input type="number" name="prix_detaillant1" id="prix_detaillant1" value="" >
                    <label for="prix_gros1">Prix de gros</label>
                    <input type="number" name="prix_gros1" id="prix_gros1" value="" >
                    <label for="prix_consommateur1">Prix consommateur :</label>
                    <input type="number" name="prix_consommateur1" id="prix_consommateur1" value="" >
                    <label for="nombre1">Nombre</label>
                    <input type="number" name="nombre1" id="nombre1" value="" >
                    <button type="submit" class="btn2">Enregistrer</button>
                </form>
            </div>
    </div>

    <!-- <div id="modal2" class="modal2">
        <div class="modal-content2">
            <h2>Confirmation</h2>
                <p>Voulez-vous vraiment supprimer cet element ?</p>
                <div class="modal-buttons2">
                    <button id="cancel-btn">Annuler</button>
                    <a id="confirm-delete" href="#">Confirmer</a>
                </div>          
        </div>
    </div> -->


    <!-- Overlay pour la boîte modale -->
    <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5);">
    </div>


    <!-- Boîte modale de confirmation -->
    <div id="modalConfirmation" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000;">
        <p>Êtes-vous sûr de vouloir supprimer cet élément ?</p>
        <button id="btnConfirmer">Confirmer</button>
        <button id="btnAnnuler">Annuler</button>
    </div>

    <script>
        // Fonction pour ouvrir la boîte modale
        function openModal() {
            document.getElementById("modal").style.display = "flex";
        }

        function openModal1(num_produit, design, prix_detaillant, prix_consommateur, prix_gros, nombre) {
            document.getElementById('design1').value = design;
            document.getElementById('prix_consommateur1').value = prix_consommateur;
            document.getElementById('prix_detaillant1').value = prix_detaillant;
            document.getElementById('prix_gros1').value = prix_gros;
            document.getElementById('nombre1').value = nombre;
           // document.getElementById('stock1').value = stock;

            const form = document.getElementById('medicament-form1');
            form.action = `index.php?entity=produit&action=update&id=${num_produit}`;

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
        }

        </script>

        <script src="/lib/sweetalert2/sweetalert2.all.min.js" ></script>
        <script src="/Views/produit/script.js"></script>
        <script src="/Views/produit/test1.js"></script>
       
        

</body>
</html>