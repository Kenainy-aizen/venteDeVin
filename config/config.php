<?php
/**
 * Configuration sécurisée utilisant les variables d'environnement
 * Le fichier config.php utilise maintenant EnvLoader
 */
require_once __DIR__ . "/EnvLoader.php";

try {
    $env = new EnvLoader(__DIR__ . "/../.env");
} catch (Exception $e) {
    // Fallback si .env n'existe pas (en production, créer le .env)
    $env = null;
    error_log(
        "Attention: Fichier .env non trouvé. Utilisation de variables par défaut.",
    );
}

// Fonction helper pour accéder aux variables d'environnement
// Vérifier que la fonction n'existe pas déjà pour éviter redéclaration
if (!function_exists("getEnv")) {
    function getEnv($key, $default = null)
    {
        global $env;
        return $env ? $env->get($key, $default) : $default ?? null;
    }
}

// Configuration de la base de données
define("DB_HOST", getEnv("DB_HOST", "localhost"));
define("DB_PORT", getEnv("DB_PORT", 3306));
define("DB_NAME", getEnv("DB_NAME", "GESTION_VENTE_VIN"));
define("DB_USER", getEnv("DB_USER", "root"));
define("DB_PASS", getEnv("DB_PASS", ""));
define("DB_CHARSET", getEnv("DB_CHARSET", "utf8mb4"));

// Configuration générale de l'application
define("APP_ENV", getEnv("APP_ENV", "production"));
define("APP_DEBUG", getEnv("APP_DEBUG", "false") === "true");
define("APP_NAME", getEnv("APP_NAME", "Gestion Vente Vin"));

// Configuration Session
define("SESSION_TIMEOUT", (int) getEnv("SESSION_TIMEOUT", 3600));

// Gestion des erreurs en fonction de l'environnement
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
} else {
    error_reporting(E_ALL);
    ini_set("display_errors", 0);
    ini_set("display_startup_errors", 0);
}
?>
