# 📋 Instructions pour les Développeurs

## 🎯 Objectif

Ce document explique comment utiliser la nouvelle structure du projet, notamment le système de variables d'environnement et les améliorations frontend.

---

## 🔧 Configuration Initiale pour les Développeurs

### 1. Cloner et Préparer le Projet

```bash
git clone <repository-url>
cd ProjetVenteVin
cp .env.example .env
```

### 2. Configurer `.env`

```env
# .env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=GESTION_VENTE_VIN
DB_USER=root
DB_PASS=votre_mot_de_passe
DB_CHARSET=utf8mb4
APP_ENV=development
APP_DEBUG=true
```

### 3. Importer la Base de Données

```bash
mysql -u root -p < db.sql
```

### 4. Démarrer le serveur local

```bash
php -S localhost:8000
# Puis accéder à http://localhost:8000
```

---

## 📝 Utiliser le Système de Configuration

### Dans n'importe quel fichier PHP

```php
<?php
// Le config.php est automatiquement chargé par index.php
// Vous pouvez accéder aux variables définies :

echo DB_HOST;      // localhost
echo DB_NAME;      // GESTION_VENTE_VIN
echo APP_NAME;     // Gestion Vente Vin
echo APP_DEBUG;    // true ou false
```

### Créer une nouvelle variable d'environnement

1. **Ajouter dans `.env.example` et `.env`:**
```env
MA_NOUVELLE_VAR=valeur
```

2. **Définir dans `config/config.php`:**
```php
define('MA_NOUVELLE_VAR', getEnv('MA_NOUVELLE_VAR', 'valeur_defaut'));
```

3. **Utiliser dans le code:**
```php
echo MA_NOUVELLE_VAR;
```

---

## 🎨 Frontend - Utiliser les Nouveaux Styles

### Fichiers CSS disponibles

```
Views/shared/
├── style.css       # Styles globaux (navbar, grid, modals)
├── components.css  # Formulaires, boutons, alertes
└── global.css      # Styles additionnels existants
```

### Importer les CSS dans vos vues

```html
<!DOCTYPE html>
<html>
<head>
    <!-- CSS Globale -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/Views/shared/style.css">
    <!-- CSS Composants -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/Views/shared/components.css">
</head>
<body>
    ...
</body>
</html>
```

---

## 🧩 Utiliser les Composants CSS

### 1. Boutons

```html
<!-- Variantes de boutons -->
<button class="btn btn-primary">Valider</button>
<button class="btn btn-success">Ajouter</button>
<button class="btn btn-danger">Supprimer</button>
<button class="btn btn-warning">Attention</button>
<button class="btn btn-info">Info</button>
<button class="btn btn-outline">Annuler</button>

<!-- Tailles -->
<button class="btn btn-primary btn-sm">Petit</button>
<button class="btn btn-primary btn-lg">Grand</button>
<button class="btn btn-primary btn-block">Pleine largeur</button>

<!-- États -->
<button class="btn btn-primary" disabled>Désactivé</button>
```

### 2. Formulaires

```html
<form method="POST">
    <h2>Créer un Produit</h2>
    
    <div class="form-group">
        <label for="nom">Nom du produit:</label>
        <input type="text" id="nom" name="nom" required>
    </div>
    
    <div class="form-group">
        <label for="prix">Prix:</label>
        <input type="number" id="prix" name="prix" step="0.01" required>
    </div>
    
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
    </div>
    
    <div class="btn-group">
        <button type="submit" class="btn btn-primary">Valider</button>
        <button type="reset" class="btn btn-outline">Réinitialiser</button>
    </div>
</form>
```

### 3. Alertes

```html
<!-- Messages de succès/erreur -->
<div class="alert alert-success">✅ Opération réussie!</div>
<div class="alert alert-danger">❌ Une erreur s'est produite.</div>
<div class="alert alert-warning">⚠️ Attention, vérifiez vos données.</div>
<div class="alert alert-info">ℹ️ Information utile.</div>
```

### 4. Badges

```html
<!-- Étiquettes colorées -->
<span class="badge badge-primary">Nouveau</span>
<span class="badge badge-success">Validé</span>
<span class="badge badge-danger">Urgent</span>
<span class="badge badge-warning">Attention</span>
```

### 5. Cartes d'Action

```html
<div class="action-card">
    <div class="action-card-header">
        <h3>Ajouter un Client</h3>
    </div>
    <div class="action-card-body">
        <!-- Contenu -->
    </div>
    <div class="action-card-footer">
        <button class="btn btn-primary">Valider</button>
        <button class="btn btn-outline">Annuler</button>
    </div>
</div>
```

### 6. Grille de Disposition

```html
<div class="row">
    <div class="col-6">
        <!-- 50% de largeur -->
    </div>
    <div class="col-6">
        <!-- 50% de largeur -->
    </div>
</div>

<div class="row">
    <div class="col-4">33%</div>
    <div class="col-4">33%</div>
    <div class="col-4">33%</div>
</div>

<div class="row">
    <div class="col-3">25%</div>
    <div class="col-9">75%</div>
</div>
```

### 7. Pagination

```html
<div class="pagination">
    <a href="?page=1" class="active">1</a>
    <a href="?page=2">2</a>
    <a href="?page=3">3</a>
    <span class="disabled">...</span>
</div>
```

---

## 🎯 Personnaliser les Couleurs

Les couleurs sont définies en CSS comme variables. Pour les modifier, éditez `Views/shared/style.css`:

```css
:root {
    --primary-color: #722f37;      /* Couleur principale (bordeaux) */
    --primary-dark: #5a2530;       /* Version sombre */
    --secondary-color: #d4af37;    /* Accent (or) */
    --success-color: #27ae60;      /* Succès (vert) */
    --danger-color: #e74c3c;       /* Erreur (rouge) */
    --warning-color: #f39c12;      /* Attention (orange) */
    --info-color: #3498db;         /* Info (bleu) */
}
```

---

## 📱 Responsive Design

Tous les composants sont responsive (mobile-first). Les breakpoints utilisés:

```css
/* Mobile: < 768px (par défaut) */
/* Tablette: 768px - 1024px */
/* Desktop: > 1024px */
```

Les grilles se réajustent automatiquement sur mobile.

---

## 🔐 Bonnes Pratiques de Sécurité

### ✅ Faire

```php
// Toujours échapper l'output
<?= htmlspecialchars($user_input) ?>

// Utiliser des requêtes préparées
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);

// Valider les entrées
if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "Email invalide";
}

// Stocker les secrets dans .env
define('API_KEY', getEnv('API_KEY'));
```

### ❌ Éviter

```php
// Ne JAMAIS faire cela
<?= $user_input ?>

// Pas de SQL injection
"SELECT * FROM users WHERE id = " . $_GET['id']

// Ne pas exposer les secrets
define('DB_PASS', 'password123');

// Ne pas afficher les erreurs en production
ini_set('display_errors', 1);
```

---

## 🚀 Déploiement en Production

### Étapes

1. **Copier tous les fichiers** (sauf `.env`)
2. **Créer `.env` sur le serveur** (ne pas copier l'original)
3. **Configurer les variables** pour la production
4. **Changer `APP_DEBUG` à `false`**
5. **Ajouter `APP_ENV=production`**

### Exemple `.env` production

```env
DB_HOST=db.production.com
DB_USER=prod_user
DB_PASS=strong_password_here
APP_ENV=production
APP_DEBUG=false
```

---

## 🐛 Débogage

### Activer le mode développement

```env
APP_ENV=development
APP_DEBUG=true
```

### Voir les logs

Les erreurs sont enregistrées en:
- Console navigateur (F12)
- Logs PHP (voir `php.ini`)
- Fichier `error_log` du serveur

### Utiliser var_dump

```php
<?php
$data = ['id' => 1, 'name' => 'Vin'];
var_dump($data);
exit;
?>
```

---

## 📚 Ressources Utiles

- **PHP Documentation:** https://www.php.net/manual/
- **CSS Variables:** https://developer.mozilla.org/en-US/docs/Web/CSS/--*
- **Flexbox Guide:** https://css-tricks.com/snippets/css/a-guide-to-flexbox/
- **OWASP Security:** https://owasp.org/www-project-top-ten/

---

## 🆘 Questions Fréquentes

### Q: Mes changements CSS ne s'appliquent pas
**R:** Vider le cache navigateur (Ctrl+Shift+Suppr ou Cmd+Shift+Suppr)

### Q: Erreur "Fichier .env non trouvé"
**R:** S'assurer que `.env` existe à la racine du projet

### Q: Comment ajouter une nouvelle page?
**R:** Créer un contrôleur, une vue dans `Views/`, et router via `index.php`

### Q: Puis-je modifier les fichiers CSS?
**R:** Oui, mais préférer ajouter des classes plutôt que de modifier les existantes

---

**Version:** 2.0  
**Dernière mise à jour:** 2024  
**Auteur:** Équipe Développement
