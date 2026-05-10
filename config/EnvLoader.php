<?php
/**
 * Classe pour charger les variables d'environnement depuis un fichier .env
 *
 * Usage:
 * $env = new EnvLoader(__DIR__ . '/../.env');
 * $dbHost = $env->get('DB_HOST', 'localhost');
 */
class EnvLoader
{
    private $variables = [];

    public function __construct($filepath)
    {
        if (!file_exists($filepath)) {
            throw new Exception("Fichier .env non trouvé: " . $filepath);
        }

        $this->load($filepath);
    }

    /**
     * Charge les variables depuis le fichier .env
     */
    private function load($filepath)
    {
        $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Ignorer les commentaires
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parser les variables KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Supprimer les guillemets
                if ((strpos($value, '"') === 0 && strrpos($value, '"') === strlen($value) - 1) ||
                    (strpos($value, "'") === 0 && strrpos($value, "'") === strlen($value) - 1)) {
                    $value = substr($value, 1, -1);
                }

                $this->variables[$key] = $value;
                // Également définir comme variable d'environnement
                putenv("$key=$value");
            }
        }
    }

    /**
     * Récupère une variable d'environnement
     *
     * @param string $key Clé de la variable
     * @param mixed $default Valeur par défaut si la variable n'existe pas
     * @return mixed Valeur de la variable ou valeur par défaut
     */
    public function get($key, $default = null)
    {
        return $this->variables[$key] ?? $_ENV[$key] ?? getenv($key) ?: $default;
    }

    /**
     * Retourne toutes les variables chargées
     */
    public function getAll()
    {
        return $this->variables;
    }

    /**
     * Vérifie si une variable existe
     */
    public function has($key)
    {
        return isset($this->variables[$key]) || isset($_ENV[$key]) || getenv($key) !== false;
    }
}
?>
