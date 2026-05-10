# 🍷 Gestion de Vente de Vin — *Lazan'i Betsileo*

Application web de gestion commerciale développée en PHP, dédiée à la vente de vins et de liqueurs. Elle permet de gérer l'ensemble du cycle de vente : produits, clients, commandes, facturation et règlements, avec un tableau de bord statistique.

---

## 📋 Table des matières

- [Fonctionnalités](#-fonctionnalités)
- [Technologies utilisées](#-technologies-utilisées)
- [Architecture du projet](#-architecture-du-projet)
- [Structure des fichiers](#-structure-des-fichiers)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Base de données](#-base-de-données)
- [Utilisation](#-utilisation)
- [Génération de PDF](#-génération-de-pdf)
- [Sécurité](#-sécurité)

---

## ✨ Fonctionnalités

### 📊 Tableau de bord
- Nombre de factures du mois en cours
- Recette totale, montant reçu et montant restant à percevoir
- Nombre de bouteilles vendues et stock total
- Liste des clients n'ayant pas réglé l'intégralité de leur facture
- Graphiques interactifs :
  - Histogramme des recettes sur les 12 derniers mois
  - Classement des produits les plus vendus (Top produits)
  - Répartition des paiements par mode (Espèces, Chèque, Carte)
  - Répartition des recettes par type de client (Détaillant, Grossiste, Consommateur)

### 📦 Gestion des produits
- Liste complète du catalogue avec stock, prix détaillant, consommateur et de gros
- Ajout, modification et suppression de produits
- Indicateur visuel de rupture de stock (stock ≤ 5 bouteilles)
- Recherche par désignation

### 👥 Gestion des clients
- Répertoire clients avec 3 types : Détaillant, Grossiste, Consommateur
- Ajout, modification et suppression
- Recherche par nom

### 📋 Gestion des commandes
- Création de bons de commande multi-lignes (session persistante)
- Statuts : *En attente* / *Réglé* avec filtrage visuel par statut
- Modification du statut et des informations d'une commande
- Génération de PDF du bon de commande
- Recherche par client

### 🧾 Gestion des ventes (Factures)
- Création de factures multi-lignes avec contrôle de stock en temps réel
- Déduction automatique du stock à chaque vente
- Filtre des ventes non réglées entre deux dates
- Génération du PDF de la facture
- Recherche par numéro de facture

### 💳 Gestion des règlements
- Enregistrement des paiements partiels ou totaux par facture
- Modes de paiement : Espèces, Chèque, Carte bancaire
- Calcul automatique du reste à payer
- Affichage groupé par facture (avec rowspan)
- Génération de reçus PDF pour les règlements sélectionnés
- Recherche dynamique des factures par nom de client (AJAX)
- Recherche par nom du client

---

## 🛠 Technologies utilisées

| Couche | Technologie |
|---|---|
| Langage serveur | PHP 8+ |
| Base de données | MySQL / MariaDB |
| Accès aux données | PDO (Prepared Statements) |
| Frontend | HTML5, CSS3, JavaScript (Vanilla) |
| Graphiques | Google Charts |
| Alertes UI | SweetAlert2 |
| Génération PDF | FPDF 1.86 |
| Encodage | UTF-8 / ISO-8859-1 (FPDF) |

---

## 🏗 Architecture du projet

Le projet suit le patron **MVC (Modèle-Vue-Contrôleur)** avec un point d'entrée unique (`index.php`).

```
Requête HTTP
     │
     ▼
index.php  ──── routage par ?entity=... & ?action=...
     │
     ├──► Controller  (logique métier, validation)
     │         │
     │         ├──► Model  (requêtes SQL via PDO)
     │         │
     │         └──► View   (rendu HTML)
     │
     └──► Réponse HTTP (HTML, JSON, PDF)
```

Le routage est assuré par deux paramètres GET :
- `entity` : `acceuil` | `produit` | `client` | `achat` | `command` | `reglement`
- `action` : `create` | `update` | `delete` | `rechercher` | `CreatePdf` | ...

---

## 📁 Structure des fichiers

```
ProjetVenteVin/
│
├── index.php                      # Point d'entrée unique (routeur)
├── db.sql                         # Dump SQL de la base de données
│
├── config/
│   ├── config.php                 # ⚙️ Credentials DB (à protéger)
│   └── db.php                     # Classe Database (connexion PDO)
│
├── Controllers/
│   ├── AccueilController.php      # Tableau de bord
│   ├── ProduitController.php      # Gestion des produits
│   ├── ClientController.php       # Gestion des clients
│   ├── AchatController.php        # Gestion des ventes/factures
│   ├── CommandController.php      # Gestion des commandes
│   └── ReglementController.php    # Gestion des règlements
│
├── Models/
│   ├── accueil.php                # Statistiques et agrégations
│   ├── Produit.php                # CRUD produits + gestion stock
│   ├── Client.php                 # CRUD clients
│   ├── Achat.php                  # CRUD factures + PDF
│   ├── Command.php                # CRUD commandes + PDF
│   └── Reglement.php              # CRUD règlements + PDF
│
├── Views/
│   ├── shared/
│   │   └── navbar.php             # 🔗 Barre de navigation partagée
│   ├── acceuil/
│   │   ├── read.php               # Page tableau de bord
│   │   ├── cssAcceuil.css         # Styles du dashboard
│   │   └── charts.js              # Initialisation Google Charts
│   ├── produit/
│   │   ├── read.php               # Liste des produits
│   │   ├── read.css
│   │   └── script.js
│   ├── client/
│   │   ├── read.php               # Liste des clients
│   │   ├── read.css
│   │   └── script.js
│   ├── achat/
│   │   ├── read.php               # Liste des factures
│   │   ├── create1.php            # Formulaire de saisie de vente
│   │   ├── read.css
│   │   └── script.js
│   ├── command/
│   │   ├── read.php               # Liste des commandes
│   │   ├── create1.php            # Formulaire de saisie de commande
│   │   ├── read.css
│   │   └── script.js
│   └── reglement/
│       ├── read.php               # Liste des règlements
│       ├── read.css
│       └── script.js
│
├── lib/
│   └── sweetalert2/               # Librairie SweetAlert2 (locale)
│
└── pdf/
    └── fpdf.php + polices         # Librairie FPDF
```

---

## 🚀 Installation

### Prérequis

- **PHP** ≥ 8.0 avec l'extension PDO MySQL activée
- **MySQL** ≥ 5.7 ou **MariaDB** ≥ 10.3
- Un serveur web : **Apache** (avec `mod_rewrite`) ou **Nginx**
- Optionnel : [XAMPP](https://www.apachefriends.org/) / [Laragon](https://laragon.org/) pour un environnement local

### Étapes

**1. Cloner ou copier le projet**
```bash
git clone <url-du-depot> /var/www/html/ProjetVenteVin
# ou copier le dossier dans le répertoire web de votre serveur
```

**2. Créer la base de données**
```sql
CREATE DATABASE GESTION_VENTE_VIN CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**3. Importer le schéma et les données**
```bash
mysql -u root -p GESTION_VENTE_VIN < db.sql
```

**4. Configurer les accès à la base de données**

Modifier le fichier `config/config.php` :
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'GESTION_VENTE_VIN');
define('DB_USER', 'votre_utilisateur');
define('DB_PASS', 'votre_mot_de_passe');
define('DB_CHARSET', 'utf8mb4');
```

**5. Accéder à l'application**

Ouvrir un navigateur et aller sur :
```
http://localhost/ProjetVenteVin/index.php
```

---

## ⚙️ Configuration

### Fichier `config/config.php`

> ⚠️ **Important** : Ce fichier contient des informations sensibles. Il ne doit **jamais** être versionné dans Git.

Ajoutez une ligne dans votre `.gitignore` :
```
config/config.php
```

Vous pouvez créer un fichier `config/config.example.php` (sans le mot de passe) à committer à la place.

### Serveur Apache

Si vous utilisez Apache, assurez-vous que `mod_rewrite` est activé et que `AllowOverride All` est configuré pour le répertoire du projet.

---

## 🗄 Base de données

### Schéma (6 tables)

```
CLIENT
├── num_client (PK)       VARCHAR(25)
├── type_client           CHAR(100)      → 'Detaillant' | 'Grossiste' | 'Consommateur'
├── nom_client            CHAR(100)
├── adresse_client        CHAR(100)
├── telephone_client      VARCHAR(25)
└── email_client          CHAR(100)

PRODUIT
├── num_produit (PK)      VARCHAR(25)
├── design                CHAR(100)
├── nombre                INT            → Stock actuel
├── prix_detaillant       INT
├── prix_consommateur     INT
└── prix_gros             INT

COMMANDE
├── num_bon_commande (PK) VARCHAR(25)
├── date_commande         DATE
├── statut                CHAR(100)
└── num_client (FK)       → CLIENT

LIGNE_COMMANDE
├── num_produit (FK)      → PRODUIT
├── num_commande (FK)     → COMMANDE
└── quantite              INT

FACTURE
├── num_facture (PK)      VARCHAR(25)
├── date_facture          DATE
├── num_client (FK)       → CLIENT
└── montant_total         INT

LIGNE_FACTURE
├── num_facture (FK)      → FACTURE
├── num_produit (FK)      → PRODUIT
└── quantite              INT

REGLEMENT
├── num_reglement (PK)    VARCHAR(25)
├── num_facture (FK)      → FACTURE
├── date_reglement        DATE
├── mode_paiement         VARCHAR(25)
├── montant_reglement     INT
└── nom_personne_reglement CHAR(100)
```

### Numérotation automatique

Les clés primaires sont générées automatiquement par l'application avec des préfixes :

| Entité | Format | Exemple |
|---|---|---|
| Client | `CLI-XXX` | `CLI-012` |
| Produit | `PRO-XXX` | `PRO-019` |
| Commande | `CMD-XXX` | `CMD-001` |
| Facture | `FAC-XXX` | `FAC-011` |
| Règlement | `REG-XXX` | `REG-015` |

---

## 📖 Utilisation

### Saisir une vente (Facture)

1. Aller dans **Ventes** → cliquer sur **+ Nouvelle vente**
2. Saisir la **date**, le **nom du client** et sélectionner un **produit** (autocomplétion)
3. Indiquer la **quantité** et cliquer sur **Valider l'Achat**
4. Répéter pour ajouter plusieurs lignes à la même facture
5. Cliquer sur **Générer le PDF** pour produire la facture, puis sur **Nouvelle Facture** pour recommencer

> Le stock est **automatiquement décrémenté** à chaque ajout de ligne. Une erreur est affichée si le stock est insuffisant.

### Enregistrer un règlement

1. Aller dans **Règlements** → cliquer sur **+ Ajouter**
2. Saisir le **nom du client** : les factures correspondantes se chargent automatiquement (AJAX)
3. Sélectionner la **facture**, le **mode de paiement** et le **montant**
4. Valider → le reste à payer est recalculé en temps réel

### Générer un reçu PDF

- **Facture** : depuis la liste des ventes, cliquer sur le bouton **PDF** de la ligne concernée
- **Bon de commande** : même principe depuis la liste des commandes
- **Reçu de règlement** : cocher un ou plusieurs règlements et cliquer sur **Générer PDF sélectionnés**

---

## 🖨 Génération de PDF

Les PDFs sont générés avec la librairie **FPDF 1.86** et utilisent la police **DejaVu** pour supporter les caractères accentués français.

Les documents générés incluent :
- **Facture** : en-tête société, coordonnées client, lignes de produits, montant total en lettres, espace signature
- **Bon de commande** : mêmes informations avec statut et lignes commandées
- **Reçu de règlement** : liste des règlements sélectionnés, total, mode de paiement, montant en lettres

---

## 🔒 Sécurité

| Point | État | Notes |
|---|---|---|
| Requêtes SQL | ✅ Sécurisées | PDO Prepared Statements sur toutes les requêtes |
| Protection XSS | ✅ Activée | `htmlspecialchars()` sur tous les affichages |
| Credentials DB | ✅ Externalisés | Variables d'environnement dans `.env` (v2.0) |
| Erreurs DB | ✅ Masquées | `error_log()` côté serveur, message générique côté client |
| Authentification | ⚠️ Absente | Pas de système de login — à ajouter en production |
| HTTPS | ⚠️ Non configuré | À activer via le serveur web en production |

> En production, il est **fortement recommandé** d'ajouter un système d'authentification (login/mot de passe) pour protéger l'accès à l'application.

---

## 🎨 Version 2.0 — Améliorations (2024)

### ✨ Nouvelles Fonctionnalités

#### 🔐 Sécurité Renforcée
- **Variables d'environnement** : Les credentials BD sont maintenant dans un fichier `.env` (non commité)
- **Classe `EnvLoader`** : Charge les variables d'environnement facilement
- **`.gitignore`** : Protège les fichiers sensibles contre les fuites
- **Gestion d'environnement** : Dev vs Production avec `APP_ENV` et `APP_DEBUG`

#### 🎨 Frontend Professionnel
- **Design moderne** : Thème viticole (bordeaux/or) cohérent
- **Responsive complet** : Mobile-first, fonctionnel sur tous les écrans
- **Composants CSS réutilisables** :
  - 6 variantes de boutons (primary, success, danger, warning, info, outline)
  - Formulaires stylisés avec validation visuelle
  - Alertes colorées (success, danger, warning, info)
  - Badges et badges
  - Cartes d'action avec layout flexible
  - Pagination élégante
- **Animations fluides** : Transitions CSS professionnelles
- **Variables CSS** : Personnalisables facilement via `:root`

#### 📚 Documentation Complète
- **`SETUP_GUIDE.md`** : Installation et configuration
- **`DEVELOPERS_GUIDE.md`** : Guide complet pour les développeurs
- **`CHANGELOG.md`** : Résumé des changements
- **`FILES_SUMMARY.md`** : Récapitulatif des fichiers créés/modifiés

### 📝 Fichiers Ajoutés/Modifiés

**Fichiers créés :**
```
config/EnvLoader.php               # Classe de gestion des .env
.env                               # Variables d'environnement (GIT IGNORED)
.env.example                       # Template pour les développeurs
.gitignore                         # Prévient les fuites de secrets
Views/shared/style.css             # CSS globale professionnelle (371 lignes)
Views/shared/components.css        # Composants réutilisables (437 lignes)
Views/template-example.html        # Boilerplate HTML pour nouvelles vues
SETUP_GUIDE.md                     # Documentation installation
DEVELOPERS_GUIDE.md               # Guide développeurs
CHANGELOG.md                       # Résumé des changements v1→v2
FILES_SUMMARY.md                   # Récapitulatif fichiers
```

**Fichiers modifiés :**
```
config/config.php                  # Chargement via EnvLoader
Views/shared/navbar.php            # Navigation avec icônes/emojis
Views/acceuil/read.php             # Référence new CSS, meilleure structure
```

### 🚀 Quick Start v2.0

1. **Copier les nouveaux fichiers** (créés et modifiés ci-dessus)
2. **Créer `.env` à partir de `.env.example`** :
   ```bash
   cp .env.example .env
   ```
3. **Éditer `.env`** avec vos paramètres BD
4. **Le reste fonctionne comme avant !** L'app charge automatiquement `.env`

### 📊 Comparaison Avant/Après

| Aspect | Avant | Après |
|--------|-------|-------|
| **Sécurité** | Credentials en texte clair | Variables d'environnement ✅ |
| **Frontend** | Basique | Professionnel & Responsive ✅ |
| **Composants CSS** | Ad-hoc | Librairie complète ✅ |
| **Documentation** | Mineure | Complète ✅ |
| **Déploiement** | Risqué | Sécurisé ✅ |

### 📖 Documentation Disponible

Pour plus de détails, consultez :
- **Installation/Déploiement** → `SETUP_GUIDE.md`
- **Développement** → `DEVELOPERS_GUIDE.md`
- **Changements effectués** → `CHANGELOG.md`
- **Fichiers modifiés** → `FILES_SUMMARY.md`

---

## 👨‍💻 Auteur

Projet réalisé dans le cadre d'un cours de développement web (L2 Informatique).

**Entreprise cible** : *Lazan'i Betsileo* — Fianarantsoa, Madagascar

**Version actuelle** : 2.0 (avec sécurité renforcée et frontend professionnel)
