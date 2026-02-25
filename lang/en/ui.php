<?php

/**
 * English UI translations for Condorcet Desktop.
 *
 * Organised by view/section. Keys are prefixed by area:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Switch to light mode',
    'switch_to_dark' => 'Switch to dark mode',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Election in progress',
    'reset' => 'Reset',
    'confirm_reset' => 'Are you sure you want to reset the entire election?',
    'warnings' => 'Warnings',
    'see_results' => 'See Results',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Candidates',
    'add' => 'Add',
    'candidate_placeholder' => 'Alice or Alice ; Bob ; Charlie',
    'candidate_hint' => 'Use semicolons to add several at once',
    'no_candidates' => 'No candidates yet.',
    'remove_candidate' => 'Remove :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Votes',
    'weight' => 'Weight',
    'quantity' => 'Quantity',
    'add_vote' => 'Add vote',
    'vote_placeholder' => 'Alice > Bob > Charlie  or  Alice = Bob > Charlie',
    'weight_auto' => 'default',
    'vote_entries' => ':count vote entry|:count vote entries',
    'total_weight' => 'total weight:',
    'no_votes' => 'No votes yet.',
    'remove_vote' => 'Remove vote',
    'bulk_add_votes' => 'Bulk add votes…',
    'parse_votes_title' => 'Bulk Add Votes',
    'parse_votes_desc' => 'Enter multiple votes, one per line. Format: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^weight * quantity</code>. Lines starting with <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> are ignored.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Add votes',
    'cancel' => 'Cancel',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Configuration',
    'implicit_ranking' => 'Implicit ranking',
    'implicit_ranking_desc' => 'When enabled, unranked candidates are implicitly tied at the last position. When disabled, they receive no points.',
    'allow_vote_weight' => 'Allow vote weight',
    'allow_vote_weight_desc' => 'When enabled, each vote can carry a different weight that amplifies its influence.',
    'no_tie_constraint' => 'No-tie constraint',
    'no_tie_constraint_desc' => 'Reject votes that contain ties. Recommended for some proportional methods (STV).',
    'number_of_seats' => 'Number of seats',
    'seats_desc' => "Required for proportional methods (STV, D'Hondt, Sainte-Laguë, etc.).",

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Voting Methods',
    'method_options' => 'Method Options',
    'group_single_winner' => 'Single Winner',
    'group_proportional' => 'Proportional',
    'group_informational' => 'Informational',
    'borda_starting' => 'Borda starting point',
    'borda_standard' => '1 (standard)',
    'kemeny_max' => 'Kemeny–Young max candidates',
    'kemeny_placeholder' => '10 (leave empty for no limit)',
    'kemeny_slow_warning' => 'Computation becomes very slow above 10 candidates.',
    'stv_quota' => 'STV quota',
    'cpo_stv_quota' => 'CPO-STV quota',
    'sainte_lague_divisor' => 'Sainte-Laguë first divisor',
    'sainte_lague_hint' => '1 = standard · 1.4 = Norwegian variant',
    'largest_remainder_quota' => 'Largest Remainder quota',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Import / Export',
    'import_cvotes' => 'Import from .cvotes format',
    'export_cvotes' => 'Export to .cvotes format',
    'import' => 'Import',
    'import_file' => 'Import file',
    'uploading' => 'Uploading…',
    'replace_warning' => 'This will replace all current data',
    'generate_export' => 'Generate export',
    'copy' => 'Copy',
    'copied' => 'Copied!',
    'download_cvotes' => 'Download .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'No results to display',
    'no_results_hint' => 'Add at least <strong>2 candidates</strong> and <strong>1 vote</strong> to compute results.',
    'no_results_methods_hint' => 'Then select one or more <strong>voting methods</strong>.',
    'condorcet_winner' => 'Condorcet Winner',
    'condorcet_loser' => 'Condorcet Loser',
    'none' => 'None',
    'no_condorcet_winner_tooltip' => 'No candidate beats every other candidate in pairwise comparison. This means there is a cycle or tie in voter preferences.',
    'no_condorcet_loser_tooltip' => 'No candidate loses to every other candidate in pairwise comparison. This means there is a cycle or tie in voter preferences.',
    'election_label' => 'Election',
    'n_candidates' => ':count candidate|:count candidates',
    'valid_votes' => 'valid votes',
    'valid_weight' => 'valid weight:',
    'overview' => 'Overview',
    'pairwise_matrix_tab' => 'Pairwise Matrix',
    'votes_tab' => 'Votes',
    'votes_list_heading' => 'All Votes',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Methods disagree on the winner.',
    'methods_disagree_desc' => 'Different voting methods can produce different results — this is the core insight of social choice theory.',
    'method' => 'Method',
    'winner' => 'Winner',
    'loser' => 'Loser',
    'full_ranking' => 'Full Ranking',
    'n_seats' => ':count seats',
    'na' => 'N/A',
    'na_proportional_winner' => 'Proportional methods elect multiple seats, not a single winner.',
    'na_informational_winner' => 'Informational methods identify a set of candidates, not a ranking.',
    'na_proportional_loser' => 'Proportional methods elect multiple seats, not a single loser.',
    'na_informational_loser' => 'Informational methods identify a set of candidates, not a ranking.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proportional · :seats seats',
    'rank' => 'Rank',
    'candidates_header' => 'Candidates',
    'tied_candidates' => 'Tied candidates',
    'computation_statistics' => 'Computation Statistics',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Pairwise Comparison Matrix',
    'pairwise_desc' => 'Each cell shows :wins / :losses for the row candidate against the column candidate.',
    'pairwise_wins' => 'wins',
    'pairwise_losses' => 'losses',
    'vs' => 'vs.',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'Candidate name cannot be empty.',
    'error_candidate_exists' => 'All candidates already exist or input is invalid.',
    'error_vote_empty' => 'Vote ranking cannot be empty.',
    'error_import_empty' => 'Paste some .cvotes content first.',
    'error_import_failed' => 'Import failed: :message',
    'error_file_import_failed' => 'File import failed: :message',
    'error_export_min_candidates' => 'Need at least 2 candidates to export.',
    'error_export_build_failed' => 'Could not build election.',
    'error_export_failed' => 'Export failed: :message',
    'warning_vote_error' => 'Vote error: :message',
    'warning_pairwise_error' => 'Pairwise error: :message',
    'error_parse_votes_empty' => 'Enter at least one vote line.',
    'error_parse_votes_need_candidates' => 'Add at least 2 candidates before bulk-adding votes.',
    'error_parse_votes_failed' => 'Failed to parse votes: :message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Computing…',
    'loading' => 'Loading election…',
    'processing_time' => ':time',
    'reset_during_loading' => 'Reset Election',

];
