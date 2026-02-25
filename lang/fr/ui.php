<?php

/**
 * Traductions françaises de l'interface Condorcet Desktop.
 *
 * Organisées par vue/section. Les clés sont préfixées par zone :
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Passer en mode clair',
    'switch_to_dark' => 'Passer en mode sombre',

    // ──────────────────────────────────────────────
    // About menu (app.blade.php)
    // ──────────────────────────────────────────────

    'about' => 'À propos',
    'view_on_github' => 'Voir sur GitHub',
    'donate' => 'Faire un don',
    'condorcet_wikipedia' => 'Méthode de Condorcet',
    'created_by' => 'Créé par',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Élection en cours',
    'reset' => 'Réinitialiser',
    'confirm_reset' => 'Êtes-vous sûr de vouloir réinitialiser l\'élection ?',
    'warnings' => 'Avertissements',
    'see_results' => 'Voir les résultats',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Candidats',
    'add' => 'Ajouter',
    'candidate_placeholder' => 'Alice ou Alice ; Bob ; Charlie',
    'candidate_hint' => 'Utilisez des points-virgules pour en ajouter plusieurs',
    'no_candidates' => 'Aucun candidat pour le moment.',
    'remove_candidate' => 'Supprimer :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Votes',
    'weight' => 'Poids',
    'quantity' => 'Quantité',
    'add_vote' => 'Ajouter un vote',
    'vote_placeholder' => 'Alice > Bob > Charlie  ou  Alice = Bob > Charlie',
    'weight_auto' => 'défaut',
    'vote_entries' => ':count bulletin de vote|:count bulletins de vote',
    'total_weight' => 'poids total :',
    'no_votes' => 'Aucun vote pour le moment.',
    'remove_vote' => 'Supprimer le vote',
    'bulk_add_votes' => 'Ajout groupé de votes…',
    'parse_votes_title' => 'Ajout groupé de votes',
    'parse_votes_desc' => 'Entrez plusieurs votes, un par ligne. Format : <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^poids * quantité</code>. Les lignes commençant par <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> sont ignorées.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Ajouter les votes',
    'cancel' => 'Annuler',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Configuration',
    'implicit_ranking' => 'Classement implicite',
    'implicit_ranking_desc' => 'Lorsqu\'activé, les candidats non classés sont implicitement à égalité en dernière position. Lorsque désactivé, ils ne reçoivent aucun point.',
    'allow_vote_weight' => 'Autoriser la pondération',
    'allow_vote_weight_desc' => 'Lorsqu\'activé, chaque vote peut avoir un poids différent qui amplifie son influence.',
    'no_tie_constraint' => 'Contrainte sans égalité',
    'no_tie_constraint_desc' => 'Rejeter les votes contenant des égalités. Recommandé pour certaines méthodes proportionnelles (STV).',
    'number_of_seats' => 'Nombre de sièges',
    'seats_desc' => 'Requis pour les méthodes proportionnelles (STV, D\'Hondt, Sainte-Laguë, etc.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Méthodes de vote',
    'method_options' => 'Options des méthodes',
    'group_single_winner' => 'Vainqueur unique',
    'group_proportional' => 'Proportionnel',
    'group_informational' => 'Informatif',
    'borda_starting' => 'Point de départ Borda',
    'borda_standard' => '1 (standard)',
    'kemeny_max' => 'Kemeny–Young max candidats',
    'kemeny_placeholder' => '10 (vide = pas de limite)',
    'kemeny_slow_warning' => 'Le calcul devient très lent au-delà de 10 candidats.',
    'stv_quota' => 'Quota STV',
    'cpo_stv_quota' => 'Quota CPO-STV',
    'sainte_lague_divisor' => 'Premier diviseur Sainte-Laguë',
    'sainte_lague_hint' => '1 = standard · 1.4 = variante norvégienne',
    'largest_remainder_quota' => 'Quota Plus forts restes',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Import / Export',
    'import_cvotes' => 'Importer au format .cvotes',
    'export_cvotes' => 'Exporter au format .cvotes',
    'import' => 'Importer',
    'import_file' => 'Importer un fichier',
    'uploading' => 'Envoi en cours…',
    'replace_warning' => 'Ceci remplacera toutes les données actuelles',
    'generate_export' => 'Générer l\'export',
    'copy' => 'Copier',
    'copied' => 'Copié !',
    'download_cvotes' => 'Télécharger .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'Aucun résultat à afficher',
    'no_results_hint' => 'Ajoutez au moins <strong>2 candidats</strong> et <strong>1 vote</strong> pour calculer les résultats.',
    'no_results_methods_hint' => 'Puis sélectionnez une ou plusieurs <strong>méthodes de vote</strong>.',
    'condorcet_winner' => 'Vainqueur de Condorcet',
    'condorcet_loser' => 'Perdant de Condorcet',
    'none' => 'Aucun',
    'no_condorcet_winner_tooltip' => 'Aucun candidat ne bat tous les autres en comparaison par paires. Cela signifie qu\'il existe un cycle ou une égalité dans les préférences des électeurs.',
    'no_condorcet_loser_tooltip' => 'Aucun candidat ne perd contre tous les autres en comparaison par paires. Cela signifie qu\'il existe un cycle ou une égalité dans les préférences des électeurs.',
    'election_label' => 'Élection',
    'n_candidates' => ':count candidat|:count candidats',
    'valid_votes' => 'votes valides',
    'valid_weight' => 'poids valide :',
    'overview' => 'Vue d\'ensemble',
    'pairwise_matrix_tab' => 'Matrice des duels',
    'votes_tab' => 'Votes',
    'votes_list_heading' => 'Tous les votes',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Les méthodes ne sont pas d\'accord sur le vainqueur.',
    'methods_disagree_desc' => 'Différentes méthodes de vote peuvent produire des résultats différents — c\'est l\'enseignement fondamental de la théorie du choix social.',
    'method' => 'Méthode',
    'winner' => 'Vainqueur',
    'loser' => 'Perdant',
    'full_ranking' => 'Classement complet',
    'n_seats' => ':count sièges',
    'na' => 'N/A',
    'na_proportional_winner' => 'Les méthodes proportionnelles élisent plusieurs sièges, pas un seul vainqueur.',
    'na_informational_winner' => 'Les méthodes informatives identifient un ensemble de candidats, pas un classement.',
    'na_proportional_loser' => 'Les méthodes proportionnelles élisent plusieurs sièges, pas un seul perdant.',
    'na_informational_loser' => 'Les méthodes informatives identifient un ensemble de candidats, pas un classement.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proportionnel · :seats sièges',
    'rank' => 'Rang',
    'candidates_header' => 'Candidats',
    'tied_candidates' => 'Candidats à égalité',
    'computation_statistics' => 'Statistiques de calcul',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Matrice de comparaison par paires',
    'pairwise_desc' => 'Chaque cellule montre les :wins / :losses du candidat en ligne contre le candidat en colonne.',
    'pairwise_wins' => 'victoires',
    'pairwise_losses' => 'défaites',
    'vs' => 'vs.',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'Le nom du candidat ne peut pas être vide.',
    'error_candidate_exists' => 'Tous les candidats existent déjà ou la saisie est invalide.',
    'error_vote_empty' => 'Le classement du vote ne peut pas être vide.',
    'error_import_empty' => 'Collez d\'abord du contenu au format .cvotes.',
    'error_import_failed' => 'Échec de l\'import : :message',
    'error_file_import_failed' => 'Échec de l\'import du fichier : :message',
    'error_export_min_candidates' => 'Il faut au moins 2 candidats pour exporter.',
    'error_export_build_failed' => 'Impossible de construire l\'élection.',
    'error_export_failed' => 'Échec de l\'export : :message',
    'warning_vote_error' => 'Erreur de vote : :message',
    'warning_pairwise_error' => 'Erreur de comparaison par paires : :message',
    'error_parse_votes_empty' => 'Saisissez au moins une ligne de vote.',
    'error_parse_votes_need_candidates' => 'Ajoutez au moins 2 candidats avant l\'ajout groupé de votes.',
    'error_parse_votes_failed' => 'Échec de l\'analyse des votes : :message',

    // ──────────────────────────────────────────────
    // Constraint validity (votes-tab.blade.php)
    // ──────────────────────────────────────────────

    'n_invalid_under_constraints' => ':count vote rejeté par les contraintes|:count votes rejetés par les contraintes',
    'status' => 'Statut',
    'vote_valid' => 'Valide',
    'vote_invalid' => 'Rejeté',
    'vote_rejected_by_constraint' => 'Ce vote est rejeté par la ou les contrainte(s) active(s) et est exclu du calcul.',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Calcul en cours…',
    'loading' => 'Chargement de l\'élection…',
    'processing_time' => ':time',
    'reset_during_loading' => 'Réinitialiser l\'élection',

];
