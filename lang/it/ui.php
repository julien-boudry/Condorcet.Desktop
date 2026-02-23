<?php

/**
 * Italian UI translations for Condorcet Desktop.
 *
 * Organised by view/section. Keys are prefixed by area:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Passa alla modalità chiara',
    'switch_to_dark' => 'Passa alla modalità scura',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Elezione in corso',
    'reset' => 'Reimposta',
    'confirm_reset' => "Sei sicuro di voler reimpostare l'intera elezione?",
    'warnings' => 'Avvisi',
    'see_results' => 'Vedi risultati',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Candidati',
    'add' => 'Aggiungi',
    'candidate_placeholder' => 'Alice o Alice ; Bob ; Charlie',
    'candidate_hint' => 'Usa il punto e virgola per aggiungerne più di uno',
    'no_candidates' => 'Nessun candidato ancora.',
    'remove_candidate' => 'Rimuovi :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Voti',
    'weight' => 'Peso',
    'quantity' => 'Quantità',
    'add_vote' => 'Aggiungi voto',
    'vote_placeholder' => 'Alice > Bob > Charlie  o  Alice = Bob > Charlie',
    'weight_auto' => 'predefinito',
    'vote_entries' => ':count voce di voto|:count voci di voto',
    'total_weight' => 'peso totale:',
    'no_votes' => 'Nessun voto ancora.',
    'remove_vote' => 'Rimuovi voto',
    'bulk_add_votes' => 'Aggiungi voti in blocco…',
    'parse_votes_title' => 'Aggiunta voti in blocco',
    'parse_votes_desc' => 'Inserisci più voti, uno per riga. Formato: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^peso * quantità</code>. Le righe che iniziano con <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> vengono ignorate.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Aggiungi voti',
    'cancel' => 'Annulla',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Configurazione',
    'implicit_ranking' => 'Classifica implicita',
    'implicit_ranking_desc' => "Quando attiva, i candidati non classificati sono implicitamente a pari merito nell'ultima posizione. Quando disattiva, non ricevono punti.",
    'allow_vote_weight' => 'Consenti peso del voto',
    'allow_vote_weight_desc' => 'Quando attivo, ogni voto può avere un peso diverso che ne amplifica l\'influenza.',
    'no_tie_constraint' => 'Vincolo di non parità',
    'no_tie_constraint_desc' => 'Rifiuta i voti che contengono parità. Consigliato per alcuni metodi proporzionali (STV).',
    'number_of_seats' => 'Numero di seggi',
    'seats_desc' => 'Necessario per i metodi proporzionali (STV, D\'Hondt, Sainte-Laguë, ecc.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Metodi di voto',
    'method_options' => 'Opzioni metodo',
    'group_single_winner' => 'Vincitore unico',
    'group_proportional' => 'Proporzionale',
    'group_informational' => 'Informativo',
    'borda_starting' => 'Punto di partenza Borda',
    'borda_standard' => '1 (standard)',
    'kemeny_max' => 'Kemeny–Young candidati massimi',
    'kemeny_placeholder' => '10 (lascia vuoto per nessun limite)',
    'kemeny_slow_warning' => 'Il calcolo diventa molto lento oltre 10 candidati.',
    'stv_quota' => 'Quoziente STV',
    'cpo_stv_quota' => 'Quoziente CPO-STV',
    'sainte_lague_divisor' => 'Primo divisore Sainte-Laguë',
    'sainte_lague_hint' => '1 = standard · 1.4 = variante norvegese',
    'largest_remainder_quota' => 'Quoziente dei resti più grandi',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Importa / Esporta',
    'import_cvotes' => 'Importa da formato .cvotes',
    'export_cvotes' => 'Esporta in formato .cvotes',
    'import' => 'Importa',
    'import_file' => 'Importa file',
    'uploading' => 'Caricamento…',
    'replace_warning' => 'Questo sostituirà tutti i dati correnti',
    'generate_export' => 'Genera esportazione',
    'copy' => 'Copia',
    'copied' => 'Copiato!',
    'download_cvotes' => 'Scarica .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'Nessun risultato da visualizzare',
    'no_results_hint' => 'Aggiungi almeno <strong>2 candidati</strong> e <strong>1 voto</strong> per calcolare i risultati.',
    'no_results_methods_hint' => 'Poi seleziona uno o più <strong>metodi di voto</strong>.',
    'condorcet_winner' => 'Vincitore di Condorcet',
    'condorcet_loser' => 'Perdente di Condorcet',
    'none' => 'Nessuno',
    'no_condorcet_winner_tooltip' => 'Nessun candidato batte tutti gli altri nel confronto a coppie. Ciò significa che esiste un ciclo o una parità nelle preferenze degli elettori.',
    'no_condorcet_loser_tooltip' => 'Nessun candidato perde contro tutti gli altri nel confronto a coppie. Ciò significa che esiste un ciclo o una parità nelle preferenze degli elettori.',
    'election_label' => 'Elezione',
    'n_candidates' => ':count candidato|:count candidati',
    'valid_votes' => 'voti validi',
    'valid_weight' => 'peso valido:',
    'overview' => 'Panoramica',
    'pairwise_matrix_tab' => 'Matrice a coppie',
    'votes_tab' => 'Voti',
    'votes_list_heading' => 'Tutti i voti',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'I metodi non concordano sul vincitore.',
    'methods_disagree_desc' => 'Metodi di voto diversi possono produrre risultati diversi — questa è l\'intuizione centrale della teoria della scelta sociale.',
    'method' => 'Metodo',
    'winner' => 'Vincitore',
    'loser' => 'Perdente',
    'full_ranking' => 'Classifica completa',
    'n_seats' => ':count seggi',
    'na' => 'N/D',
    'na_proportional_winner' => 'I metodi proporzionali eleggono più seggi, non un singolo vincitore.',
    'na_informational_winner' => 'I metodi informativi identificano un insieme di candidati, non una classifica.',
    'na_proportional_loser' => 'I metodi proporzionali eleggono più seggi, non un singolo perdente.',
    'na_informational_loser' => 'I metodi informativi identificano un insieme di candidati, non una classifica.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proporzionale · :seats seggi',
    'rank' => 'Posizione',
    'candidates_header' => 'Candidati',
    'tied_candidates' => 'Candidati a pari merito',
    'computation_statistics' => 'Statistiche di calcolo',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Matrice di confronto a coppie',
    'pairwise_desc' => 'Ogni cella mostra le <span class="font-semibold text-green-600 dark:text-green-400">vittorie</span> / <span class="font-semibold text-red-600 dark:text-red-400">sconfitte</span> del candidato di riga contro quello di colonna.',
    'vs' => 'vs.',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'Il nome del candidato non può essere vuoto.',
    'error_candidate_exists' => 'Tutti i candidati esistono già o l\'input non è valido.',
    'error_vote_empty' => 'La classifica del voto non può essere vuota.',
    'error_import_empty' => 'Incolla prima del contenuto .cvotes.',
    'error_import_failed' => 'Importazione fallita: :message',
    'error_file_import_failed' => 'Importazione file fallita: :message',
    'error_export_min_candidates' => 'Servono almeno 2 candidati per esportare.',
    'error_export_build_failed' => 'Impossibile costruire l\'elezione.',
    'error_export_failed' => 'Esportazione fallita: :message',
    'warning_vote_error' => 'Errore voto: :message',
    'warning_pairwise_error' => 'Errore confronto a coppie: :message',
    'error_parse_votes_empty' => 'Inserisci almeno una riga di voto.',
    'error_parse_votes_need_candidates' => 'Aggiungi almeno 2 candidati prima dell\'aggiunta in blocco.',
    'error_parse_votes_failed' => 'Errore nell\'analisi dei voti: :message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Calcolo in corso…',
    'loading' => 'Caricamento elezione…',
    'processing_time' => ':time',

];
