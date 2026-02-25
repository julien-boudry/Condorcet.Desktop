<?php

/**
 * Ghomálá' UI translations for Condorcet Desktop.
 *
 * Organised by view/section. Keys are prefixed by area:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Kwǎʼ pə́ ŋwàʼnyə̀',
    'switch_to_dark' => 'Kwǎʼ pə́ jʉ̀m',

    // ──────────────────────────────────────────────
    // About menu (app.blade.php)
    // ──────────────────────────────────────────────

    'about' => 'M̀fɑ̌ɑ̌',
    'view_on_github' => 'Yɔ̌ GitHub',
    'donate' => 'Fɑ́ nkwè',
    'condorcet_wikipedia' => 'Condorcet method',
    'created_by' => 'Pə́ gùŋ',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Ntsǒ ŋkwɛ̌ yǎ gɔ',
    'reset' => 'Lɑ̀ nə̀ tə̂',
    'confirm_reset' => 'O gɔ sǐ lɑ̀ ntsǒ ŋkwɛ̌ tsə̂ pú nə̀ tə̂?',
    'warnings' => 'Mnyə̀ŋtə̀',
    'see_results' => 'Yɔ̌ mfʉ̀ʼ',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Pɑ̌ kwɛ̌',
    'add' => 'Gùŋ',
    'candidate_placeholder' => 'Alice kɑ Alice ; Bob ; Charlie',
    'candidate_hint' => 'Fa bisémbi pə́ gùŋ pɑ̌ yɔ̀m tə́ m̀fɑ̌ɑ̌',
    'no_candidates' => 'Pɑ̌ kwɛ̌ ka tyə́ pɑ̀.',
    'remove_candidate' => 'Kwyǎ :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Mtsǒ ŋkwɛ̌',
    'weight' => 'Gʉ̀ʼ',
    'quantity' => 'Ŋkhʉ̀ɔ̌',
    'add_vote' => 'Gùŋ ntsǒ ŋkwɛ̌',
    'vote_placeholder' => 'Alice > Bob > Charlie  kɑ  Alice = Bob > Charlie',
    'weight_auto' => 'nə̀ŋ gùŋ',
    'vote_entries' => ':count ntsǒ ŋkwɛ̌|:count mtsǒ ŋkwɛ̌',
    'total_weight' => 'gʉ̀ʼ tsə̂ pú:',
    'no_votes' => 'Mtsǒ ŋkwɛ̌ ka tyə́ pɑ̀.',
    'remove_vote' => 'Kwyǎ ntsǒ ŋkwɛ̌',
    'bulk_add_votes' => 'Gùŋ mtsǒ ŋkwɛ̌ mɛ̌ntsǒ…',
    'parse_votes_title' => 'Gùŋ mtsǒ ŋkwɛ̌ mɛ̌ntsǒ',
    'parse_votes_desc' => 'Ŋwa̍ʼ mtsǒ ŋkwɛ̌ mɛ̌ntsǒ, ntsǒ ŋkwɛ̌ mɔ̀ʼ pə́ mɔ̀ʼ kɛ̀ʼ. Ntʉɔ: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^gʉ̀ʼ * ŋkhʉ̀ɔ̌</code>. Mkɛ̀ʼ myǎ lɑ̀ nə̀ <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> tə̀ pɑ̀ ŋkhǔm.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Gùŋ mtsǒ ŋkwɛ̌',
    'cancel' => 'Kwîntə̀',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Ŋkhǐ ntʉɔ',
    'implicit_ranking' => 'Ntʉɔ nə̀ m̀yǎ',
    'implicit_ranking_desc' => 'Á gɔ sí pɑ̌ kwɛ̌ pa tə́ fǎ ntʉɔ pú nthʉ̀ɔ̀ mɔ̀ʼ nə̀ m̀yǎ. Á ka gɔ́ sí pɑ̌ tə́ kwɑ̌ tɑ̀ bə̀ɛ̀.',
    'allow_vote_weight' => 'Shyǎ gʉ̀ʼ mtsǒ ŋkwɛ̌',
    'allow_vote_weight_desc' => 'Á gɔ sí bɑ̀ ntsǒ ŋkwɛ̌ mɔ̀ʼmɔ̀ʼ tə́ bɑ̀ nə̀ gʉ̀ʼ tsyá tə́ shyǎ ntǔm yǎ.',
    'no_tie_constraint' => 'Kwyǎ ntûŋə̂',
    'no_tie_constraint_desc' => 'Kwyǎ mtsǒ ŋkwɛ̌ myǎ bɑ̀ nə̀ ntûŋə̂. Mbɑ̀ pə̀ mbhʉ̀ɔ̀ proporsionɛ̀l (STV).',
    'number_of_seats' => 'Ŋkhʉ̀ɔ̌ mtsʉ̀ʼ',
    'seats_desc' => 'Mbɑ̀ pə̀ mbhʉ̀ɔ̀ proporsionɛ̀l (STV, D\'Hondt, Sainte-Laguë, pyə̀.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Mbhʉ̀ɔ̀ mtsǒ ŋkwɛ̌',
    'method_options' => 'Mtsǒ pə̀ mbhʉ̀ɔ̀',
    'group_single_winner' => 'Gʉ̀ɔ mɔ̀ʼ',
    'group_proportional' => 'Proporsionɛ̀l',
    'group_informational' => 'Mfə̀ʼ',
    'borda_starting' => 'Ntʉ̀ɔ̀ nlɑ̀ Borda',
    'borda_standard' => '1 (nə̀ŋ gùŋ)',
    'kemeny_max' => 'Kemeny–Young pɑ̌ kwɛ̌ pɑ̀ yɔ̀m',
    'kemeny_placeholder' => '10 (piŋ = ka ntʉ̀ɔ̀ hyə̌)',
    'kemeny_slow_warning' => 'Ŋkhǔm shyǎ bɑ̀ ŋwàʼ pɑ̌ kwɛ̌ cyə̀ 10.',
    'stv_quota' => 'Kwota STV',
    'cpo_stv_quota' => 'Kwota CPO-STV',
    'sainte_lague_divisor' => 'Nkwǎ ntʉ̀ɔ̀tə̂ Sainte-Laguë',
    'sainte_lague_hint' => '1 = nə̀ŋ gùŋ · 1.4 = njɛ̀ʼ Norvège',
    'largest_remainder_quota' => 'Kwota mkɛ̀ʼ mpfǎ',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Lɔ̌ / Nthǔm',
    'import_cvotes' => 'Lɔ̌ nə̀ ntʉɔ .cvotes',
    'export_cvotes' => 'Nthǔm nə̀ ntʉɔ .cvotes',
    'import' => 'Lɔ̌',
    'import_file' => 'Lɔ̌ ŋwa̍ʼnə̀',
    'uploading' => 'Ntǎŋ…',
    'replace_warning' => 'Yɔ̌ gɔ kwɑ̌ mfə̀ʼ tsə̂ pú nyǎ tyə́ nɛ̀',
    'generate_export' => 'Bɑŋ nthǔm',
    'copy' => 'Kwɑ̀',
    'copied' => 'Pú kwɑ̀!',
    'download_cvotes' => 'Lɔ̌ .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'Mfʉ̀ʼ ka tyə́ pɑ̀ pə́ la̍ʼtə̀',
    'no_results_hint' => 'Gùŋ tə̀ <strong>pɑ̌ kwɛ̌ 2</strong> pú <strong>ntsǒ ŋkwɛ̌ 1</strong> pə́ ŋkhǔm mfʉ̀ʼ.',
    'no_results_methods_hint' => 'Pɑ̀ shyǎ <strong>mbhʉ̀ɔ̀ mtsǒ ŋkwɛ̌</strong> mɔ̀ʼ kɑ pɑ̀ yɔ̀m.',
    'condorcet_winner' => 'Gʉ̀ɔ Condorcet',
    'condorcet_loser' => 'Nthʉ̀ɔ̀ Condorcet',
    'none' => 'Ka tyə́',
    'no_condorcet_winner_tooltip' => 'Mɔ̀ʼ pa kwɛ̌ kɑ́ gʉ̀ɔ pɑ̌ tə́ pú nə̀ ŋkhǔm pə̀ bibaa. Yɔ̌ tsɑ̀ʼ lɑ̀ njɛ̀ʼ kɑ ntûŋə̂ nthʉ̀ɔ̀ mtsǒ pə̀ pɑ̌ kwɛ̌.',
    'no_condorcet_loser_tooltip' => 'Mɔ̀ʼ pa kwɛ̌ kɑ́ nthʉ̀ɔ̀ nə̀ pɑ̌ tə́ pú nə̀ ŋkhǔm pə̀ bibaa. Yɔ̌ tsɑ̀ʼ lɑ̀ njɛ̀ʼ kɑ ntûŋə̂ nthʉ̀ɔ̀ mtsǒ pə̀ pɑ̌ kwɛ̌.',
    'election_label' => 'Ntsǒ ŋkwɛ̌',
    'n_candidates' => ':count pa kwɛ̌|:count pɑ̌ kwɛ̌',
    'valid_votes' => 'mtsǒ ŋkwɛ̌ myǎ gɔ',
    'valid_weight' => 'gʉ̀ʼ yǎ gɔ:',
    'overview' => 'Yɔ̌ tsə̂ pú',
    'pairwise_matrix_tab' => 'Tablo pə̀ bibaa',
    'votes_tab' => 'Mtsǒ ŋkwɛ̌',
    'votes_list_heading' => 'Mtsǒ ŋkwɛ̌ tsə̂ pú',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Mbhʉ̀ɔ̀ ka kwîŋə̂ pə́ gʉ̀ɔ mɔ̀ʼ.',
    'methods_disagree_desc' => 'Mbhʉ̀ɔ̀ mtsǒ ŋkwɛ̌ myǎ tɑ̀ tə́ bɑ̀ nə̀ mfʉ̀ʼ myǎ tɑ̀ — yɔ̌ bɑ̀ ñɑ̀ nlɑ̀ théorie pə̀ tsǒ mbɔ̀ŋ.',
    'method' => 'Mbhʉ̀ɔ̀',
    'winner' => 'Gʉ̀ɔ',
    'loser' => 'Nthʉ̀ɔ̀',
    'full_ranking' => 'Ntʉɔ tsə̂ pú',
    'n_seats' => ':count mtsʉ̀ʼ',
    'na' => 'N/A',
    'na_proportional_winner' => 'Mbhʉ̀ɔ̀ proporsionɛ̀l shyǎ mtsʉ̀ʼ myɔ̀m, tee gʉ̀ɔ mɔ̀ʼ.',
    'na_informational_winner' => 'Mbhʉ̀ɔ̀ mfə̀ʼ la̍ʼtə̀ ŋkhʉ̀ɔ̌ pɑ̌ kwɛ̌, tee ntʉɔ.',
    'na_proportional_loser' => 'Mbhʉ̀ɔ̀ proporsionɛ̀l shyǎ mtsʉ̀ʼ myɔ̀m, tee nthʉ̀ɔ̀ mɔ̀ʼ.',
    'na_informational_loser' => 'Mbhʉ̀ɔ̀ mfə̀ʼ la̍ʼtə̀ ŋkhʉ̀ɔ̌ pɑ̌ kwɛ̌, tee ntʉɔ.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proporsionɛ̀l · :seats mtsʉ̀ʼ',
    'rank' => 'Ntʉɔ',
    'candidates_header' => 'Pɑ̌ kwɛ̌',
    'tied_candidates' => 'Pɑ̌ kwɛ̌ pǎ ntûŋə̂',
    'computation_statistics' => 'Statistik ŋkhǔm',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Tablo ŋkhǔm pə̀ bibaa',
    'pairwise_desc' => 'Bɑ̀ selil mɔ̀ʼmɔ̀ʼ la̍ʼtə̀ :wins / :losses pə̀ pa kwɛ̌ nə̀ kɛ̀ʼ nə̀ pa kwɛ̌ nə̀ tsʉ̀.',
    'pairwise_wins' => 'mgʉ̀ɔ',
    'pairwise_losses' => 'mnthʉ̀ɔ̀',
    'vs' => 'pú',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'Lǐŋ pa kwɛ̌ kɑ́ bɑ̀ piŋ.',
    'error_candidate_exists' => 'Pɑ̌ kwɛ̌ pú tyə́ gɑ́ kɑ ntila kɑ́ gɔ.',
    'error_vote_empty' => 'Ntʉɔ ntsǒ ŋkwɛ̌ kɑ́ bɑ̀ piŋ.',
    'error_import_empty' => 'Ta̍ʼ bisu mfə̀ʼ .cvotes.',
    'error_import_failed' => 'Lɔ̌ kɑ́ gɔ pɑ̀: :message',
    'error_file_import_failed' => 'Lɔ̌ ŋwa̍ʼnə̀ kɑ́ gɔ pɑ̀: :message',
    'error_export_min_candidates' => 'Mbɑ̀ tə̀ pɑ̌ kwɛ̌ 2 pə́ nthǔm.',
    'error_export_build_failed' => 'Kɑ́ pɑ̀ŋ ntsǒ ŋkwɛ̌.',
    'error_export_failed' => 'Nthǔm kɑ́ gɔ pɑ̀: :message',
    'warning_vote_error' => 'Pɛ̀ ntsǒ ŋkwɛ̌: :message',
    'warning_pairwise_error' => 'Pɛ̀ ŋkhǔm pə̀ bibaa: :message',
    'error_parse_votes_empty' => 'Ŋwa̍ʼ tə̀ kɛ̀ʼ ntsǒ ŋkwɛ̌ mɔ̀ʼ.',
    'error_parse_votes_need_candidates' => 'Gùŋ tə̀ pɑ̌ kwɛ̌ 2 bisu pə́ gùŋ mtsǒ ŋkwɛ̌ mɛ̌ntsǒ.',
    'error_parse_votes_failed' => 'Kɑ́ pɑ̀ŋ ŋkhǔm mtsǒ ŋkwɛ̌: :message',

    // ──────────────────────────────────────────────
    // Constraint validity (votes-tab.blade.php)
    // ──────────────────────────────────────────────

    'n_invalid_under_constraints' => ':count ntsǒ ŋkwɛ̌ tə̀ jɛ̌ʼ pə̀ nsɛ̌m|:count mtsǒ ŋkwɛ̌ tə̀ jɛ̌ʼ pə̀ nsɛ̌m',
    'status' => 'Nɛ̀',
    'vote_valid' => 'Tə̀ pɑ̌',
    'vote_invalid' => 'Tə̀ jɛ̌ʼ',
    'vote_rejected_by_constraint' => 'Ntsǒ ŋkwɛ̌ yɔ̀ tə̀ jɛ̌ʼ pə̀ nsɛ̌m mə̀ yɑ̀, kɑ́ pɑ̀ŋ nɑ́ ŋkhǔm.',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Ŋkhǔm…',
    'loading' => 'Ntǎŋ ntsǒ ŋkwɛ̌…',
    'processing_time' => ':time',
    'reset_during_loading' => 'Sɛ̌t ntsǒ ŋkwɛ̌',

];
