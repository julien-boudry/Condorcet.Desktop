<?php

/**
 * Esperanto UI translations for Condorcet Desktop.
 *
 * Organised by view/section. Keys are prefixed by area:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Ŝanĝi al hela reĝimo',
    'switch_to_dark' => 'Ŝanĝi al malhela reĝimo',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Elekto en progreso',
    'reset' => 'Restarigi',
    'confirm_reset' => 'Ĉu vi certas, ke vi volas restarigi la tutan elekton?',
    'warnings' => 'Avertoj',
    'see_results' => 'Vidi rezultojn',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Kandidatoj',
    'add' => 'Aldoni',
    'candidate_placeholder' => 'Alice aŭ Alice ; Bob ; Charlie',
    'candidate_hint' => 'Uzu punktokomojn por aldoni plurajn samtempe',
    'no_candidates' => 'Ankoraŭ neniuj kandidatoj.',
    'remove_candidate' => 'Forigi :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Voĉdonoj',
    'weight' => 'Pezo',
    'quantity' => 'Kvanto',
    'add_vote' => 'Aldoni voĉdonon',
    'vote_placeholder' => 'Alice > Bob > Charlie  aŭ  Alice = Bob > Charlie',
    'weight_auto' => 'defaŭlta',
    'vote_entries' => ':count voĉdona enskribo|:count voĉdonaj enskriboj',
    'total_weight' => 'totala pezo:',
    'no_votes' => 'Ankoraŭ neniuj voĉdonoj.',
    'remove_vote' => 'Forigi voĉdonon',
    'bulk_add_votes' => 'Amase aldoni voĉdonojn…',
    'parse_votes_title' => 'Amasa aldono de voĉdonoj',
    'parse_votes_desc' => 'Enigu plurajn voĉdonojn, unu per linio. Formato: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^pezo * kvanto</code>. Linioj komencanĉaj per <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> estas ignoritaj.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Aldoni voĉdonojn',
    'cancel' => 'Nuligi',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Agordo',
    'implicit_ranking' => 'Implica rangigo',
    'implicit_ranking_desc' => 'Kiam aktivigita, nerangigitaj kandidatoj estas implice egalaj en la lasta pozicio. Kiam malaktivigita, ili ricevas neniujn poentojn.',
    'allow_vote_weight' => 'Permesi voĉdonan pezon',
    'allow_vote_weight_desc' => 'Kiam aktivigita, ĉiu voĉdono povas havi malsaman pezon por pligrandigi sian influon.',
    'no_tie_constraint' => 'Senegala restrikto',
    'no_tie_constraint_desc' => 'Rifuzi voĉdonojn kun egalrangigoj. Rekomendata por iuj proporciaj metodoj (STV).',
    'number_of_seats' => 'Nombro de sidlokoj',
    'seats_desc' => 'Bezonata por proporciaj metodoj (STV, D\'Hondt, Sainte-Laguë, ktp.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Voĉdonaj metodoj',
    'method_options' => 'Metodaj opcioj',
    'group_single_winner' => 'Unuopa venkanto',
    'group_proportional' => 'Proporcia',
    'group_informational' => 'Informa',
    'borda_starting' => 'Borda-komencpunkto',
    'borda_standard' => '1 (norma)',
    'kemeny_max' => 'Kemeny–Young maksa kandidatnombro',
    'kemeny_placeholder' => '10 (lasu malplena por senlima)',
    'kemeny_slow_warning' => 'Kalkulo fariĝas tre malrapida super 10 kandidatoj.',
    'stv_quota' => 'STV-kvoto',
    'cpo_stv_quota' => 'CPO-STV-kvoto',
    'sainte_lague_divisor' => 'Sainte-Laguë unua dividanto',
    'sainte_lague_hint' => '1 = norma · 1.4 = Norvega varianto',
    'largest_remainder_quota' => 'Plej granda restkvoto',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Importi / Eksporti',
    'import_cvotes' => 'Importi el .cvotes formato',
    'export_cvotes' => 'Eksporti al .cvotes formato',
    'import' => 'Importi',
    'import_file' => 'Importi dosieron',
    'uploading' => 'Alŝutante…',
    'replace_warning' => 'Tio ĉi anstataŭigos ĉiujn nunajn datumojn',
    'generate_export' => 'Generi eksporton',
    'copy' => 'Kopii',
    'copied' => 'Kopiita!',
    'download_cvotes' => 'Elŝuti .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'Neniuj rezultoj montreblaj',
    'no_results_hint' => 'Aldonu almenaŭ <strong>2 kandidatojn</strong> kaj <strong>1 voĉdonon</strong> por kalkuli rezultojn.',
    'no_results_methods_hint' => 'Poste elektu unu aŭ plurajn <strong>voĉdonajn metodojn</strong>.',
    'condorcet_winner' => 'Condorcet-venkanto',
    'condorcet_loser' => 'Condorcet-perdanto',
    'none' => 'Neniu',
    'no_condorcet_winner_tooltip' => 'Neniu kandidato venkas ĉiujn aliajn kandidatojn en duopa komparo. Tio signifas, ke estas ciklo aŭ egaleco en preferoj de voĉdonantoj.',
    'no_condorcet_loser_tooltip' => 'Neniu kandidato perdas kontraŭ ĉiuj aliaj kandidatoj en duopa komparo. Tio signifas, ke estas ciklo aŭ egaleco en preferoj de voĉdonantoj.',
    'election_label' => 'Elekto',
    'n_candidates' => ':count kandidato|:count kandidatoj',
    'valid_votes' => 'validaj voĉdonoj',
    'valid_weight' => 'valida pezo:',
    'overview' => 'Superrigardo',
    'pairwise_matrix_tab' => 'Duopa kompara matrico',
    'votes_tab' => 'Voĉdonoj',
    'votes_list_heading' => 'Ĉiuj voĉdonoj',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Metodoj ne konsentas pri la venkanto.',
    'methods_disagree_desc' => 'Malsamaj voĉdonaj metodoj povas produkti malsamajn rezultojn — tio estas la centra kompreno de socia elektoteorio.',
    'method' => 'Metodo',
    'winner' => 'Venkanto',
    'loser' => 'Perdanto',
    'full_ranking' => 'Plena rangigo',
    'n_seats' => ':count sidlokoj',
    'na' => 'N/A',
    'na_proportional_winner' => 'Proporciaj metodoj elektas plurajn sidlokojn, ne unuopan venkanton.',
    'na_informational_winner' => 'Informaj metodoj identigas aron da kandidatoj, ne rangigon.',
    'na_proportional_loser' => 'Proporciaj metodoj elektas plurajn sidlokojn, ne unuopan perdanton.',
    'na_informational_loser' => 'Informaj metodoj identigas aron da kandidatoj, ne rangigon.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proporcia · :seats sidlokoj',
    'rank' => 'Rango',
    'candidates_header' => 'Kandidatoj',
    'tied_candidates' => 'Egalrangaj kandidatoj',
    'computation_statistics' => 'Kalkulaj statistikoj',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Duopa kompara matrico',
    'pairwise_desc' => 'Ĉiu ĉelo montras :wins / :losses por la vica kandidato kontraŭ la kolumna kandidato.',
    'pairwise_wins' => 'venkojn',
    'pairwise_losses' => 'perdojn',
    'vs' => 'kontraŭ',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'Kandidata nomo ne povas esti malplena.',
    'error_candidate_exists' => 'Ĉiuj kandidatoj jam ekzistas aŭ la enigo estas nevalida.',
    'error_vote_empty' => 'Voĉdona rangigo ne povas esti malplena.',
    'error_import_empty' => 'Unue algluu iom da .cvotes enhavo.',
    'error_import_failed' => 'Importo malsukcesis: :message',
    'error_file_import_failed' => 'Dosiera importo malsukcesis: :message',
    'error_export_min_candidates' => 'Bezonas almenaŭ 2 kandidatojn por eksporti.',
    'error_export_build_failed' => 'Ne eblis konstrui elekton.',
    'error_export_failed' => 'Eksporto malsukcesis: :message',
    'warning_vote_error' => 'Voĉdona eraro: :message',
    'warning_pairwise_error' => 'Duopa kompara eraro: :message',
    'error_parse_votes_empty' => 'Enigu almenaŭ unu voĉdonan linion.',
    'error_parse_votes_need_candidates' => 'Aldonu almenaŭ 2 kandidatojn antaŭ amasa voĉdon-aldono.',
    'error_parse_votes_failed' => 'Malsukcesis analizi voĉdonojn: :message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Kalkulante…',
    'loading' => 'Ŝarĝante elekton…',
    'processing_time' => ':time',
    'reset_during_loading' => 'Restarigi elekton',

];
