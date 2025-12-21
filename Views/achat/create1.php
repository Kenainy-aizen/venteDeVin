<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACHAT</title>
    <link rel="stylesheet" href="/lib/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="/Views/acceuil/cssAcceuil1.css">
      <script src="/lib/sweetalert2/sweetalert2.all.min.js"></script>
   

    
</head>


<body>
    <header class="navbarAll">
    <div>
          <a class="logo">VENTE</a>
          
          <div class="" id="mynavbar">
            <ul>
            <li class="nav-item">
                  <a href="index.php?entity=acceuil&action=read"><button class="nav-link">Dashbord</button></a>
                </li>
                <li class="nav-item">
                  <a href="index.php?entity=produit&action=read"><button class="nav-link" >Produits</button></a>
                </li>
                <li class="nav-item">
                  <a href="index.php?entity=achat&action=read"><button class="nav-link">Achats</button></a>
                </li>
                <li class="nav-item">
                   <a href="index.php?entity=client&action=read"><button class="nav-link">Clients</button></a>
                 <li class="nav-item">
                   <a href="index.php?entity=reglement&action=read"><button class="nav-link">Reglements</button></a>
                </li>
                 <li class="nav-item">
                   <a href="index.php?entity=command&action=read"><button class="nav-link">Commandes</button></a>
                </li>
          </li>
              
            </ul>
            <!-- <form class="d-flex" action="">
              <input id="inputRecherche" type="text" placeholder="Taper ici pour rechercher">
              <button class="btnRecherche">Rechercher</button>
            </form>
          <a href=""><button class="notif">N</button></a> -->
            
          </div>
        </div>
    </header>
<div class="container">
        <!-- Formulaire d'achat à gauche -->
        <section id="formulaire-achat">
            <h2>Formulaire d'Achat</h2><br>
            <form id="formAchat" method="post" action="index.php?entity=achat&action=create">

                <label for="dateAchat">Date d'Achat:</label>
                <input type="date" id="dateAchat" name="dateAchat" value="<?= date('Y-m-d') ?>">

                <label for="nomClient">Nom du Client:</label>
                <input type="text" id="nomClient" name="nomClient" >

                <label for="nom_produit">Nom de produit:</label>
                <input type="text" id="nom_produit" name="nom_produit" list="listeProduits" >

                <datalist id="listeProduits"></datalist>

                      <script>
                      const inputProduit = document.getElementById("nom_produit");
                      const dataList = document.getElementById("listeProduits");

                      inputProduit.addEventListener("input", function() {
                          const query = this.value;

                          if (query.length < 1) return; // attendre 1 lettre avant de chercher

                          fetch(`index.php?entity=achat&action=ajaxProduits&q=${encodeURIComponent(query)}`)
                              .then(response => response.json())
                              .then(data => {
                                  dataList.innerHTML = "";
                                  data.forEach(item => {
                                      const option = document.createElement("option");
                                      option.value = item.design;
                                      option.textContent = `${item.design} - Stock: ${item.nombre}`;
                                      dataList.appendChild(option);
                                  });
                              })
                              .catch(error => console.error("Erreur AJAX:", error));
                      });
                      </script>


                <label for="nbr">Quantité:</label>
                <input type="number" id="nbr" name="nbr" >

                <button type="submit" name="valider">Valider l'Achat</button>
                <button type="submit" name="annuler">Annuler l'Achat</button>
                <button type="submit" name="nouvelleFacture">Nouvelle Facture</button>
                <button type="submit" name="genererPdf">Generer le pdf</button>

            </form>
            <?php if (!empty($message)) : ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
        </section>

        <!-- Affichage des achats à droite -->
        <section id="affichage-achats">
         
        <?php
            if (isset($_SESSION['numAchat'])) {
                $resultat = $this->model->afficherFacture($_SESSION['numAchat']);
                echo $resultat;
            }
        ?>
        </section>
    </div>
    <!-- <footer>
        <p>&copy; 2025 Gestion de vente</p>
    </footer> -->

</body>
</html>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formAchat");

    // Restaurer les valeurs si elles existent
    const nomClientSaved = sessionStorage.getItem("nomClient");
    const dateAchatSaved = sessionStorage.getItem("dateAchat");
    if (nomClientSaved) document.getElementById("nomClient").value = nomClientSaved;
    if (dateAchatSaved) document.getElementById("dateAchat").value = dateAchatSaved;

    form.addEventListener("submit", function (event) {
      const boutonClique = event.submitter?.name;

      if (boutonClique === "valider") {
        // Sauvegarder nom et date
        const nomClient = document.getElementById("nomClient").value;
        const dateAchat = document.getElementById("dateAchat").value;
        sessionStorage.setItem("nomClient", nomClient);
        sessionStorage.setItem("dateAchat", dateAchat);
      } else if (["annuler", "nouvelleFacture"].includes(boutonClique)) {
        // Si on annule ou commence une nouvelle facture, on vide la mémoire
        sessionStorage.removeItem("nomClient");
        sessionStorage.removeItem("dateAchat");
      }
    });
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formAchat");

    // Restaurer les valeurs si elles existent
    const nomClientSaved = sessionStorage.getItem("nomClient");
    const dateAchatSaved = sessionStorage.getItem("dateAchat");
    if (nomClientSaved) document.getElementById("nomClient").value = nomClientSaved;
    if (dateAchatSaved) document.getElementById("dateAchat").value = dateAchatSaved;

    form.addEventListener("submit", function (event) {
      const boutonClique = event.submitter?.name;

      if (boutonClique === "valider") {
        // Sauvegarder nom et date
        const nomClient = document.getElementById("nomClient").value;
        const dateAchat = document.getElementById("dateAchat").value;
        sessionStorage.setItem("nomClient", nomClient);
        sessionStorage.setItem("dateAchat", dateAchat);
      } else if (["annuler", "nouvelleFacture"].includes(boutonClique)) {
        // Si on annule ou commence une nouvelle facture, on vide la mémoire
        sessionStorage.removeItem("nomClient");
        sessionStorage.removeItem("dateAchat");
      }
    });
  });
</script>


<?php if (isset($_SESSION['error_message'])): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erreur de stock',
        text: '<?= $_SESSION['error_message'] ?> (Stock initial : <?= $_SESSION['stock_initial'] ?>)',
        confirmButtonText: 'OK',
        confirmButtonColor: '#d33',
        allowOutsideClick: false,
        allowEscapeKey: false
    });
</script>
<?php
    unset($_SESSION['error_message']);
    unset($_SESSION['stock_initial']);
endif;
?>


