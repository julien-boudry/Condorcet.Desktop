<?php

/**
 * Traduktion na Duálá naInterface Condorcet Desktop.
 *
 * Bi nyangamɛna tɛ mwásó/sɛksiɔn. Biki bi nyé bwambi tɛ plási:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Kwɛya na mwɛ́nda múnjɛ́lɛ́',
    'switch_to_dark' => 'Kwɛya na mwɛ́nda dídí',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Dipɔ́si di péna',
    'reset' => 'Bwámbisɛ',
    'confirm_reset' => 'O búlá o búlá dipɔ́si nyɛ́ɛ́sɛ́?',
    'warnings' => 'Malɛ́pti',
    'see_results' => 'Tánda bipɔdɔl',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Bato ba dipɔ́si',
    'add' => 'Bɛ́nɛ',
    'candidate_placeholder' => 'Alice ɔ Alice ; Bob ; Charlie',
    'candidate_hint' => 'Sálá na bisɛmbi i bɛ́nɛ bato ba mingi',
    'no_candidates' => 'Bato ba dipɔ́si ɛ́wɛ́.',
    'remove_candidate' => 'Lɔ́ngɔ :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Mipɔ́si',
    'weight' => 'Bwámu',
    'quantity' => 'Ndɔgɔ',
    'add_vote' => 'Bɛ́nɛ epɔ́si',
    'vote_placeholder' => 'Alice > Bob > Charlie  ɔ  Alice = Bob > Charlie',
    'weight_auto' => 'sásá',
    'vote_entries' => ':count epɔ́si|:count mipɔ́si',
    'total_weight' => 'bwámu ɛsɛ́ɛ́:',
    'no_votes' => 'Mipɔ́si ɛ́wɛ́.',
    'remove_vote' => 'Lɔ́ngɔ epɔ́si',
    'bulk_add_votes' => 'Bɛ́nɛ mipɔ́si mí mingi…',
    'parse_votes_title' => 'Bɛ́nɛ mipɔ́si mí mingi',
    'parse_votes_desc' => 'Kɔmɛ mipɔ́si mí mingi, epɔ́si ɛmɔ́sɔ́ na lɛ́n ɛmɔ́sɔ́. Fɔ́rma: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^bwámu * ndɔgɔ</code>. Malɛ́n ma bwámbisɛ na <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> ma úba.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Bɛ́nɛ mipɔ́si',
    'cancel' => 'Lɔ́ngɔsɛ',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Ndɔ́ngɔ',
    'implicit_ranking' => 'Nyanganɛ na nse',
    'implicit_ranking_desc' => 'Dí pɛ́na, bato ba dipɔ́si ba ba nyangamɛna pɛ ba yé na plási ɛsúkúlú na ɛmɔ́sɔ́. Dí péna pɛ, ba kɛ púndɔ kwálá.',
    'allow_vote_weight' => 'Dúngísɛ bwámu mipɔ́si',
    'allow_vote_weight_desc' => 'Dí pɛ́na, ɛsɛ́ɛ́ epɔ́si ɛ nla gwɛ bwámu musíya mú nyéngɛl ɛsɔ̀ŋ ɛnɛ́.',
    'no_tie_constraint' => 'Mbódi ɛ́kálɛ',
    'no_tie_constraint_desc' => 'Lɔ́ngísɛ mipɔ́si mí gwɛ́ bíkálɛ. Dí sɔ́mbɛ na manjɛ́l ma proporsionɛl (STV).',
    'number_of_seats' => 'Ndɔgɔ na bitíka',
    'seats_desc' => 'Dí nyéni na manjɛ́l ma proporsionɛl (STV, D\'Hondt, Sainte-Laguë, ns.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Manjɛ́l ma mipɔ́si',
    'method_options' => 'Bilɔ̃ bi manjɛ́l',
    'group_single_winner' => 'Múnyéni ɛmɔ́sɔ́',
    'group_proportional' => 'Proporsionɛl',
    'group_informational' => 'Mamɛ́ya',
    'borda_starting' => 'Bwámbisɛ Borda',
    'borda_standard' => '1 (sásá)',
    'kemeny_max' => 'Kemeny–Young bato ba dipɔ́si ba mingi',
    'kemeny_placeholder' => '10 (ɛwɛ = púndɔ ndɔ́ngɔ)',
    'kemeny_slow_warning' => 'Esálɛ ɛ́ yé ndɔ́mbɛ dí bato ba dipɔ́si ba lɔ̀lɔ 10.',
    'stv_quota' => 'Kwóta STV',
    'cpo_stv_quota' => 'Kwóta CPO-STV',
    'sainte_lague_divisor' => 'Musángísɛ wambɛ wɛ Sainte-Laguë',
    'sainte_lague_hint' => '1 = sásá · 1.4 = njɛ́l na Norvège',
    'largest_remainder_quota' => 'Kwóta bisɛ́s ɛnɛnɛ',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Njɔ̃ / Tímbísɛ',
    'import_cvotes' => 'Njɔ̃ na fɔ́rma .cvotes',
    'export_cvotes' => 'Tímbísɛ na fɔ́rma .cvotes',
    'import' => 'Njɔ̃',
    'import_file' => 'Njɔ̃ kádi',
    'uploading' => 'Ntímbísɛ…',
    'replace_warning' => 'Édi ɛ́ pɛ́mɛ́sɛ data ɛsɛ́ɛ́ nyɛ́ɛ́sɛ́',
    'generate_export' => 'Bɔ́lɔ tímbísɛ',
    'copy' => 'Kɔ́bi',
    'copied' => 'Dí kɔ́bi!',
    'download_cvotes' => 'Bɛ́sɛ .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'Bipɔdɔl ɛ́wɛ́ i tándɔ',
    'no_results_hint' => 'Bɛ́nɛ ngɛ́a <strong>bato ba dipɔ́si 2</strong> na <strong>epɔ́si 1</strong> i sálɛ bipɔdɔl.',
    'no_results_methods_hint' => 'Ná pɔ̃ <strong>manjɛ́l ma mipɔ́si</strong> ɛmɔ́sɔ́ ɔ ma mingi.',
    'condorcet_winner' => 'Múnyéni Condorcet',
    'condorcet_loser' => 'Mudibɛ Condorcet',
    'none' => 'Ɛ́wɛ́',
    'no_condorcet_winner_tooltip' => 'Muto ɛ́wɛ́ a nyéni bato basɛ́ɛ́ na esálɛ na bibáa. Édi ɛ́ tándɔ le eyé njɛ́l ɔ ɛkálɛ na bilɔ̃ bi bato ba dipɔ́si.',
    'no_condorcet_loser_tooltip' => 'Muto ɛ́wɛ́ a dibɛ na bato basɛ́ɛ́ na esálɛ na bibáa. Édi ɛ́ tándɔ le eyé njɛ́l ɔ ɛkálɛ na bilɔ̃ bi bato ba dipɔ́si.',
    'election_label' => 'Dipɔ́si',
    'n_candidates' => ':count muto a dipɔ́si|:count bato ba dipɔ́si',
    'valid_votes' => 'mipɔ́si mí búáni',
    'valid_weight' => 'bwámu mú búáni:',
    'overview' => 'Étándá ɛsɛ́ɛ́',
    'pairwise_matrix_tab' => 'Táblo a bibáa',
    'votes_tab' => 'Mipɔ́si',
    'votes_list_heading' => 'Mipɔ́si nyɛ́ɛ́sɛ́',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Manjɛ́l ma ída pɛ na múnyéni ɛmɔ́sɔ́.',
    'methods_disagree_desc' => 'Manjɛ́l ma mipɔ́si ma musíya ma nla bɔ́lɔ bipɔdɔl bi musíya — édi ɛ́ yé mambɛ́ya ɛnɛnɛ na théorie a bilɔ̃ bi mbódi.',
    'method' => 'Njɛ́l',
    'winner' => 'Múnyéni',
    'loser' => 'Mudibɛ',
    'full_ranking' => 'Nyanganɛ nyɛ́ɛ́sɛ́',
    'n_seats' => ':count bitíka',
    'na' => 'N/A',
    'na_proportional_winner' => 'Manjɛ́l ma proporsionɛl ma pɔ̃ bitíka bi mingi, pɛ múnyéni ɛmɔ́sɔ́.',
    'na_informational_winner' => 'Manjɛ́l ma mamɛ́ya ma tándɔ likɔ́da la bato ba dipɔ́si, pɛ nyanganɛ.',
    'na_proportional_loser' => 'Manjɛ́l ma proporsionɛl ma pɔ̃ bitíka bi mingi, pɛ mudibɛ ɛmɔ́sɔ́.',
    'na_informational_loser' => 'Manjɛ́l ma mamɛ́ya ma tándɔ likɔ́da la bato ba dipɔ́si, pɛ nyanganɛ.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proporsionɛl · :seats bitíka',
    'rank' => 'Nyanganɛ',
    'candidates_header' => 'Bato ba dipɔ́si',
    'tied_candidates' => 'Bato ba dipɔ́si ba ɛkálɛ',
    'computation_statistics' => 'Statistik na esálɛ',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Táblo a esálɛ na bibáa',
    'pairwise_desc' => 'Ɛsɛ́ɛ́ selil ɛ tándɔ :wins / :losses bi muto na lɛ́n yɛsu muto na kolón.',
    'pairwise_wins' => 'binyéni',
    'pairwise_losses' => 'bidibɛ',
    'vs' => 'na',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'Dína dá muto a dipɔ́si dí nla pɛ ba ɛwɛ.',
    'error_candidate_exists' => 'Bato ba dipɔ́si basɛ́ɛ́ ba yé kála ɔ njɔ̃ í búáni pɛ.',
    'error_vote_empty' => 'Nyanganɛ a epɔ́si ɛ nla pɛ ba ɛwɛ.',
    'error_import_empty' => 'Kɔ́misɛ bisu makata ma .cvotes.',
    'error_import_failed' => 'Njɔ̃ í dúbá: :message',
    'error_file_import_failed' => 'Njɔ̃ kádi í dúbá: :message',
    'error_export_min_candidates' => 'Dí nyéni ngɛ́a bato ba dipɔ́si 2 i tímbísɛ.',
    'error_export_build_failed' => 'Ɛ́ nla pɛ bɔ́lɔ dipɔ́si.',
    'error_export_failed' => 'Tímbísɛ í dúbá: :message',
    'warning_vote_error' => 'Edúba a epɔ́si: :message',
    'warning_pairwise_error' => 'Edúba a esálɛ na bibáa: :message',
    'error_parse_votes_empty' => 'Kɔmɛ ngɛ́a lɛ́n a epɔ́si ɛmɔ́sɔ́.',
    'error_parse_votes_need_candidates' => 'Bɛ́nɛ ngɛ́a bato ba dipɔ́si 2 bisu bɛ́nɛ mipɔ́si mí mingi.',
    'error_parse_votes_failed' => 'Ɛ́ nla pɛ sálɛ mipɔ́si: :message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Esálɛ…',
    'loading' => 'Nlɔ́dɔ dipɔ́si…',
    'processing_time' => ':time',

];
