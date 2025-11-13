<?php
    // inclusions/functions.php

    /**
     * Calcule le temps écoulé depuis une date
     * @param string $datetime - Date au format MySQL (Y-m-d H:i:s)
     */
    function timeAgo($datetime) {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        // Plus d'un an
        if ($diff->y > 0) {
            return $diff->y == 1 ? "il y a 1 an" : "il y a {$diff->y} ans";
        }
        
        // Plus d'un mois
        if ($diff->m > 0) {
            return $diff->m == 1 ? "il y a 1 mois" : "il y a {$diff->m} mois";
        }
        
        // Plus d'une semaine
        if ($diff->d >= 7) {
            $weeks = floor($diff->d / 7);
            return $weeks == 1 ? "il y a 1 semaine" : "il y a {$weeks} semaines";
        }
        
        // Plus d'un jour
        if ($diff->d > 0) {
            return $diff->d == 1 ? "il y a 1 jour" : "il y a {$diff->d} jours";
        }
        
        // Plus d'une heure
        if ($diff->h > 0) {
            return $diff->h == 1 ? "il y a 1 heure" : "il y a {$diff->h} heures";
        }
        
        // Plus d'une minute
        if ($diff->i > 0) {
            return $diff->i == 1 ? "il y a 1 minute" : "il y a {$diff->i} minutes";
        }
        
        // Moins d'une minute
        return "à l'instant";
    }

    /**
     * Détermine le statut en ligne/hors ligne d'un utilisateur
     * @param string $last_activity - Date de dernière activité
     * @return array - ['status', 'text', 'class']
     */
    function getUserStatus($last_activity) {
        $now = new DateTime();
        $last = new DateTime($last_activity);
        $diff = $now->diff($last);
        
        // En ligne si actif dans les 5 dernières minutes
        $total_minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
        
        if ($total_minutes <= 5) {
            return [
                'status' => 'online',
                'text' => 'en ligne',
                'class' => 'bg-green-500'
            ];
        } else {
            return [
                'status' => 'offline',
                'text' => timeAgo($last_activity),
                'class' => 'bg-gray-400'
            ];
        }
    }
?>