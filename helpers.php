<?php
/**
 * Fichier de fonctions utilitaires globales
 * Gère notamment les messages flash (succès / erreur)
 */

if (!function_exists('setFlash')) {
    /**
     * Définit un message flash dans la session.
     *
     * @param string $message Le message à afficher
     */
    function setFlash(string $message): void {
        $_SESSION['flash'] = $message;
    }
}

if (!function_exists('getFlash')) {
    /**
     * Récupère le message flash s’il existe, puis le supprime.
     *
     * @return string|null Le message flash ou null s’il n’existe pas
     */
    function getFlash(): ?string {
        if (!empty($_SESSION['flash'])) {
            $msg = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $msg;
        }
        return null;
    }
}
