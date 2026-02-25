<?php

/**
 * Ñañ i kal Basaa bi gwét Condorcet Desktop.
 *
 * Bi nhilha ni gwét/bôdôl. Bikéé bi gwé bôdôl ni hikii:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Hôla i bégés ngii',
    'switch_to_dark' => 'Hôla i bégés ñôñ',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Bisombo bi yé i pam',
    'reset' => 'Bôdôl sép',
    'confirm_reset' => 'U ngwés bôdôl bisombo gwobisôna sép?',
    'warnings' => 'Maébég',
    'see_results' => 'Béñge bipôdôl',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Bôt ba somb',
    'add' => 'Bôñôl',
    'candidate_placeholder' => 'Alice tole Alice ; Bob ; Charlie',
    'candidate_hint' => 'Tjél bisémbi i bôñôl ba yôm bôt',
    'no_candidates' => 'A tuu bôt ba somb.',
    'remove_candidate' => 'Hégda :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Bisombo',
    'weight' => 'Ngidja',
    'quantity' => 'Ndôg',
    'add_vote' => 'Bôñôl sombo',
    'vote_placeholder' => 'Alice > Bob > Charlie  tole  Alice = Bob > Charlie',
    'weight_auto' => 'maliga',
    'vote_entries' => ':count sombo|:count bisombo',
    'total_weight' => 'ngidja yosôna:',
    'no_votes' => 'A tuu bisombo.',
    'remove_vote' => 'Hégda sombo',
    'bulk_add_votes' => 'Bôñôl bisombo bi yôm…',
    'parse_votes_title' => 'Bôñôl bisombo bi yôm',
    'parse_votes_desc' => 'Tila bisombo bi yôm, sombo yada i lign yada. Bégés: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^ngidja * ndôg</code>. Malign ma bôdôl ni <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> ma héñla.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Bôñôl bisombo',
    'cancel' => 'Nûs',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Ndéñ',
    'implicit_ranking' => 'Nihilha ni mbus',
    'implicit_ranking_desc' => 'Hiki i yé i lôñ, bôt ba somb ba ba ta héñla ba yé i mbom yada i sôñ. Hiki i ta héñla, ba bé bôl nkéñ.',
    'allow_vote_weight' => 'Lôñ ngidja bisombo',
    'allow_vote_weight_desc' => 'Hiki i yé i lôñ, hikii sombo i nla gwé ngidja nyañ i nyéñgél bôdôl yé.',
    'no_tie_constraint' => 'Mbôgi tômblô',
    'no_tie_constraint_desc' => 'Nûs bisombo bi gwé bitômblô. Bi sômbla ni manjel ma proporsionel (STV).',
    'number_of_seats' => 'Ndôg i bitééga',
    'seats_desc' => 'Bi nyéñ ni manjel ma proporsionel (STV, D\'Hondt, Sainte-Laguë, ns.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Manjel ma bisombo',
    'method_options' => 'Biloñ bi manjel',
    'group_single_winner' => 'Nyéñ yada',
    'group_proportional' => 'Proporsionel',
    'group_informational' => 'Mambéhna',
    'borda_starting' => 'Bôdôl i Borda',
    'borda_standard' => '1 (maliga)',
    'kemeny_max' => 'Kemeny–Young bôt ba somb ba yôm',
    'kemeny_placeholder' => '10 (hala = tuu ndéñ)',
    'kemeny_slow_warning' => 'Kayéhna i yé ntômba hiki bôt ba somb ba lôl 10.',
    'stv_quota' => 'Kwota STV',
    'cpo_stv_quota' => 'Kwota CPO-STV',
    'sainte_lague_divisor' => 'Njôñ i bisu Sainte-Laguë',
    'sainte_lague_hint' => '1 = maliga · 1.4 = njel i Norvège',
    'largest_remainder_quota' => 'Kwota bisés bi nlam',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Ñôñôl / Timbis',
    'import_cvotes' => 'Ñôñôl i bégés .cvotes',
    'export_cvotes' => 'Timbis i bégés .cvotes',
    'import' => 'Ñôñôl',
    'import_file' => 'Ñôñôl kaat',
    'uploading' => 'Ntimbis…',
    'replace_warning' => 'Hala a pémés gwobisôna bi data bi nyen',
    'generate_export' => 'Bôl timbis',
    'copy' => 'Kôbi',
    'copied' => 'Bi kôbi!',
    'download_cvotes' => 'Bés .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'A tuu bipôdôl i lés',
    'no_results_hint' => 'Bôñôl gwal <strong>bôt ba somb 2</strong> ni <strong>sombo 1</strong> i kayéh bipôdôl.',
    'no_results_methods_hint' => 'Hégda nyañ <strong>manjel ma bisombo</strong> yada tole ma yôm.',
    'condorcet_winner' => 'Nyéñ Condorcet',
    'condorcet_loser' => 'Nkwo Condorcet',
    'none' => 'Tuu',
    'no_condorcet_winner_tooltip' => 'A tuu mut a nyéñ bôt bobasôna i kayéhna i bibaa. Hala a kal le hala a gwé njel tole tômblô i biloñ bi bôt ba somb.',
    'no_condorcet_loser_tooltip' => 'A tuu mut a kwo ni bôt bobasôna i kayéhna i bibaa. Hala a kal le hala a gwé njel tole tômblô i biloñ bi bôt ba somb.',
    'election_label' => 'Bisombo',
    'n_candidates' => ':count mut a somb|:count bôt ba somb',
    'valid_votes' => 'bisombo bi nlam',
    'valid_weight' => 'ngidja i nlam:',
    'overview' => 'Béñge yosôna',
    'pairwise_matrix_tab' => 'Tablo i bibaa',
    'votes_tab' => 'Bisombo',
    'votes_list_heading' => 'Bisombo gwobisôna',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Manjel ma yéñ bé i mut yada.',
    'methods_disagree_desc' => 'Manjel ma bisombo ma nyañ ma nla ti bipôdôl bi nyañ — hala a yé ñañ i nlam i théorie i biloñ bi mbôgi.',
    'method' => 'Njel',
    'winner' => 'Nyéñ',
    'loser' => 'Nkwo',
    'full_ranking' => 'Nihilha yosôna',
    'n_seats' => ':count bitééga',
    'na' => 'N/A',
    'na_proportional_winner' => 'Manjel ma proporsionel ma somb bitééga bi yôm, tee mut yada.',
    'na_informational_winner' => 'Manjel ma mambéhna ma lés likoda li bôt ba somb, tee nihilha.',
    'na_proportional_loser' => 'Manjel ma proporsionel ma somb bitééga bi yôm, tee nkwo yada.',
    'na_informational_loser' => 'Manjel ma mambéhna ma lés likoda li bôt ba somb, tee nihilha.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proporsionel · :seats bitééga',
    'rank' => 'Nihilha',
    'candidates_header' => 'Bôt ba somb',
    'tied_candidates' => 'Bôt ba somb ba tômblô',
    'computation_statistics' => 'Statistik i kayéhna',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Tablo i kayéhna i bibaa',
    'pairwise_desc' => 'Hikii selil i lés :wins / :losses bi mut i lign yés mut i kolôn.',
    'pairwise_wins' => 'binyéñ',
    'pairwise_losses' => 'bikwo',
    'vs' => 'ni',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'Liñ li mut a somb li nla bé ba hala.',
    'error_candidate_exists' => 'Bôt ba somb bobasôna ba yé gwal tole ntila i nlam bé.',
    'error_vote_empty' => 'Nihilha i sombo i nla bé ba hala.',
    'error_import_empty' => 'Tômb bisu makata ma .cvotes.',
    'error_import_failed' => 'Ñôñôl i bé pam bé: :message',
    'error_file_import_failed' => 'Ñôñôl kaat i bé pam bé: :message',
    'error_export_min_candidates' => 'Bi nyéñ gwal bôt ba somb 2 i timbis.',
    'error_export_build_failed' => 'Bi nla bé bôl bisombo.',
    'error_export_failed' => 'Timbis i bé pam bé: :message',
    'warning_vote_error' => 'Njôô i sombo: :message',
    'warning_pairwise_error' => 'Njôô i kayéhna i bibaa: :message',
    'error_parse_votes_empty' => 'Tila gwal lign i sombo yada.',
    'error_parse_votes_need_candidates' => 'Bôñôl gwal bôt ba somb 2 bisu i bôñôl bisombo bi yôm.',
    'error_parse_votes_failed' => 'Bi nla bé kayéh bisombo: :message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Kayéhna…',
    'loading' => 'Nlôdôl bisombo…',
    'processing_time' => ':time',
    'reset_during_loading' => 'Bɔ̂l bisombo',

];
