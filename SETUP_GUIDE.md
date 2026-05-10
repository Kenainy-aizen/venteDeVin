# 🍷 Gestion de Vente de Vin - Guide de Configuration

## 📋 Table des matières
- [Installation](#installation)
- [Configuration Environnement](#configuration-environnement)
- [Structure du Projet](#structure-du-projet)
- [Sécurité](#sécurité)
- [Utilisation](#utilisation)

---

## 🚀 Installation

### Prérequis
- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx avec support PHP
- Composer (optionnel)

### Étapes

1. **Cloner le projet**
```bash
git clone <repository-url>
cd ProjetVenteVin
```

2. **Créer le fichier .env**
```bash
cp .env.example .env
```

3. **Configurer la base de données dans .env**
```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=GESTION_VENTE_VIN
DB_USER=root
DB_PASS=votre_mot_de_passe
DB_CHARSET=utf8mb4
```

4. **Importer la base de données**
```bash
mysql -u root -p GESTION_VENTE_VIN < db.sql
```

5. **Configurer le serveur web**
- Pointer le `DocumentRoot` vers le dossier du projet
- S'assurer que le dossier contient un `index.php`

---

## ⚙️ Configuration Environnement

### Fichier `.env`

Le projet utilise un système de variables d'environnement pour sécuriser les informations sensibles.

#### Variables disponibles :

**Base de Données**
```env
DB_HOST=localhost          # Hôte MySQL
DB_PORT=3306              # Port MySQL
DB_NAME=GESTION_VENTE_VIN # Nom de la base
DB_USER=root              # Utilisateur MySQL
DB_PASS=password          # Mot de passe MySQL
DB_CHARSET=utf8mb4        # Encodage
```

**Application**
```env
APP_ENV=development        # development | production
APP_DEBUG=true            # true | false (mode débogage)
APP_NAME="Gestion Vente Vin"  # Nom de l'application
SESSION_TIMEOUT=3600      # Durée session (secondes)
```

**Email (optionnel)**
```env
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USER=email@gmail.com
MAIL_PASS=app_password
MAIL_FROM=noreply@ventevins.com
```

### ⚠️ Important

- **Ne JAMAIS commiter le fichier `.env`** (fichier dans `.gitignore`)
- Utiliser `.env.example` comme référence de template
- Chaque environnement (dev, staging, prod) doit avoir son propre `.env`

---

## 📁 Structure du Projet

```
ProjetVenteVin/
├── config/
│   ├── config.php         # Configuration sécurisée
│   ├── db.php            # Classe Database
│   ├── EnvLoader.php     # Chargeur de variables env
│
├── Controllers/          # Logique métier
│   ├── AccueilController.php
│   ├── ProduitController.php
│   └── ...
│
├── Models/              # Modèles de données
│
├── Views/               # Templates HTML
│   ├── shared/
│   │   ├── navbar.php   # Navigation commune
│   │   ├── style.css    # Styles globaux (NOUVEAU)
│   │   └── global.css   # Styles additionnels
│   ├── acceuil/
│   ├── produit/
│   └── ...
│
├── .env                 # Variables environnement (GIT IGNORED)
├── .env.example         # Template .env
├── .gitignore          # Fichiers à ignorer dans Git
├── index.php           # Point d'entrée
└── db.sql              # Schéma base de données
```

---

## 🔒 Sécurité

### Améliorations apportées

#### 1. **Variables d'environnement**
- Les identifiants BD ne sont plus en clair dans le code
- Utilisation de la classe `EnvLoader` pour charger `.env`

#### 2. **Gestion des erreurs**
```php
// En développement: affiche les erreurs
APP_DEBUG=true

// En production: cache les erreurs
APP_DEBUG=false
```

#### 3. **.gitignore**
Prévient la fuite d'informations sensibles :
```
.env
vendor/
logs/
cache/
.idea/
.vscode/
```

### Bonnes pratiques

✅ **À faire :**
- Toujours utiliser `htmlspecialchars()` pour l'affichage
- Utiliser des requêtes préparées (PDO) pour les BDD
- Valider et nettoyer les entrées utilisateur
- Stocker les secrets dans `.env`

❌ **À éviter :**
- Commiter `.env` ou mots de passe en clair
- Afficher les erreurs en production
- Utiliser des variables GET directement dans les requêtes SQL

---

## 🎨 Frontend - Améliorations

### Nouveau système de styling

**Fichier CSS unifiée :** `Views/shared/style.css`

#### Caractéristiques :
- Design moderne avec thème viticole (rouge/or)
- Responsive (mobile-first)
- Variables CSS personnalisables
- Animations fluides
- Composants réutilisables

#### Colors (personnalisables)
```css
:root {
    --primary-color: #722f37;      /* Bordeaux */
    --secondary-color: #d4af37;    /* Or */
    --success-color: #27ae60;      /* Vert */
    --danger-color: #e74c3c;       /* Rouge */
    --warning-color: #f39c12;      /* Orange */
}
```

#### Composants
- **Navbar** : Navigation sticky avec active state
- **Cards** : Statistiques avec icônes et animations
- **Tables** : Design professionnel avec hover
- **Modals** : Popups avec animations
- **Responsive Grid** : Auto-layout sur tous les écrans

---

## 📖 Utilisation

### Démarrer l'application

1. Accéder à l'URL : `http://localhost/ProjetVenteVin`
2. Vérifier que la BD est connectée
3. La page d'accueil affiche le tableau de bord

### Accéder aux sections

- **Tableau de bord** : `/index.php?entity=acceuil`
- **Produits** : `/index.php?entity=produit`
- **Clients** : `/index.php?entity=client`
- **Ventes** : `/index.php?entity=achat`
- **Commandes** : `/index.php?entity=command`
- **Règlements** : `/index.php?entity=reglement`

---

## 🐛 Dépannage

### Erreur : "Fichier .env non trouvé"

**Solution :** 
```bash
cp .env.example .env
# Éditer .env avec vos paramètres
```

### Erreur de connexion BD

**Vérifier :**
- Les paramètres dans `.env`
- Que MySQL est en cours d'exécution
- Les permissions de l'utilisateur MySQL

### Erreurs d'affichage CSS

**Solutions :**
- Vider le cache navigateur (Ctrl+Shift+Del)
- Vérifier le lien CSS : `href="<?= BASE_URL ?>/Views/shared/style.css"`
- S'assurer que `BASE_URL` est correct dans `index.php`

---

## 📦 Classe EnvLoader

Utilisation manuelle :
```php
require_once 'config/EnvLoader.php';

$env = new EnvLoader(__DIR__ . '/.env');
$dbHost = $env->get('DB_HOST', 'localhost');
$dbUser = $env->get('DB_USER');

// Vérifier si une variable existe
if ($env->has('MAIL_HOST')) {
    // ...
}
```

---

## 🤝 Support

Pour des questions ou des problèmes, veuillez :
1. Vérifier le fichier `.env`
2. Consulter les logs (dossier `logs/`)
3. Vérifier que la BD est configurée correctement

---

**Dernière mise à jour :** 2024
**Version :** 2.0 (avec support environnement et frontend amélioré)
