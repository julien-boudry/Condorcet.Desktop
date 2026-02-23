<?php

/**
 * Polskie tłumaczenia interfejsu Condorcet Desktop.
 *
 * Zorganizowane według widoku/sekcji. Klucze są poprzedzone obszarem:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Przełącz na tryb jasny',
    'switch_to_dark' => 'Przełącz na tryb ciemny',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Wybory w toku',
    'reset' => 'Resetuj',
    'confirm_reset' => 'Czy na pewno chcesz zresetować całe wybory?',
    'warnings' => 'Ostrzeżenia',
    'see_results' => 'Zobacz wyniki',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Kandydaci',
    'add' => 'Dodaj',
    'candidate_placeholder' => 'Alice lub Alice ; Bob ; Charlie',
    'candidate_hint' => 'Użyj średników, aby dodać kilku naraz',
    'no_candidates' => 'Brak kandydatów.',
    'remove_candidate' => 'Usuń :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Głosy',
    'weight' => 'Waga',
    'quantity' => 'Ilość',
    'add_vote' => 'Dodaj głos',
    'vote_placeholder' => 'Alice > Bob > Charlie  lub  Alice = Bob > Charlie',
    'weight_auto' => 'domyślna',
    'vote_entries' => ':count głos|:count głosy|:count głosów',
    'total_weight' => 'łączna waga:',
    'no_votes' => 'Brak głosów.',
    'remove_vote' => 'Usuń głos',
    'bulk_add_votes' => 'Dodaj głosy hurtowo…',
    'parse_votes_title' => 'Dodawanie głosów hurtowo',
    'parse_votes_desc' => 'Wprowadź wiele głosów, po jednym na linię. Format: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^waga * ilość</code>. Linie zaczynające się od <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> są pomijane.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Dodaj głosy',
    'cancel' => 'Anuluj',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Konfiguracja',
    'implicit_ranking' => 'Niejawne rankingowanie',
    'implicit_ranking_desc' => 'Gdy włączone, niesklasyfikowani kandydaci są niejawnie remisowani na ostatniej pozycji. Gdy wyłączone, nie otrzymują punktów.',
    'allow_vote_weight' => 'Zezwól na wagę głosów',
    'allow_vote_weight_desc' => 'Gdy włączone, każdy głos może mieć inną wagę, która wzmacnia jego wpływ.',
    'no_tie_constraint' => 'Zakaz remisów',
    'no_tie_constraint_desc' => 'Odrzuć głosy zawierające remisy. Zalecane dla niektórych metod proporcjonalnych (STV).',
    'number_of_seats' => 'Liczba mandatów',
    'seats_desc' => 'Wymagane dla metod proporcjonalnych (STV, D\'Hondt, Sainte-Laguë, itp.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Metody głosowania',
    'method_options' => 'Opcje metod',
    'group_single_winner' => 'Jeden zwycięzca',
    'group_proportional' => 'Proporcjonalne',
    'group_informational' => 'Informacyjne',
    'borda_starting' => 'Punkt startowy Borda',
    'borda_standard' => '1 (standardowy)',
    'kemeny_max' => 'Kemeny–Young maks. kandydatów',
    'kemeny_placeholder' => '10 (puste = bez limitu)',
    'kemeny_slow_warning' => 'Obliczenia stają się bardzo wolne powyżej 10 kandydatów.',
    'stv_quota' => 'Kwota STV',
    'cpo_stv_quota' => 'Kwota CPO-STV',
    'sainte_lague_divisor' => 'Pierwszy dzielnik Sainte-Laguë',
    'sainte_lague_hint' => '1 = standardowy · 1.4 = wariant norweski',
    'largest_remainder_quota' => 'Kwota największych reszt',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Import / Eksport',
    'import_cvotes' => 'Importuj z formatu .cvotes',
    'export_cvotes' => 'Eksportuj do formatu .cvotes',
    'import' => 'Importuj',
    'import_file' => 'Importuj plik',
    'uploading' => 'Przesyłanie…',
    'replace_warning' => 'To zastąpi wszystkie bieżące dane',
    'generate_export' => 'Generuj eksport',
    'copy' => 'Kopiuj',
    'copied' => 'Skopiowano!',
    'download_cvotes' => 'Pobierz .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'Brak wyników do wyświetlenia',
    'no_results_hint' => 'Dodaj co najmniej <strong>2 kandydatów</strong> i <strong>1 głos</strong>, aby obliczyć wyniki.',
    'no_results_methods_hint' => 'Następnie wybierz jedną lub więcej <strong>metod głosowania</strong>.',
    'condorcet_winner' => 'Zwycięzca Condorceta',
    'condorcet_loser' => 'Przegrany Condorceta',
    'none' => 'Brak',
    'no_condorcet_winner_tooltip' => 'Żaden kandydat nie pokonuje wszystkich innych w porównaniu parami. Oznacza to, że istnieje cykl lub remis w preferencjach wyborców.',
    'no_condorcet_loser_tooltip' => 'Żaden kandydat nie przegrywa ze wszystkimi innymi w porównaniu parami. Oznacza to, że istnieje cykl lub remis w preferencjach wyborców.',
    'election_label' => 'Wybory',
    'n_candidates' => ':count kandydat|:count kandydatów',
    'valid_votes' => 'głosy ważne',
    'valid_weight' => 'ważna waga:',
    'overview' => 'Przegląd',
    'pairwise_matrix_tab' => 'Macierz porównań',
    'votes_tab' => 'Głosy',
    'votes_list_heading' => 'Wszystkie głosy',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Metody nie zgadzają się co do zwycięzcy.',
    'methods_disagree_desc' => 'Różne metody głosowania mogą dawać różne wyniki — to fundamentalne odkrycie teorii wyboru społecznego.',
    'method' => 'Metoda',
    'winner' => 'Zwycięzca',
    'loser' => 'Przegrany',
    'full_ranking' => 'Pełne rankingowanie',
    'n_seats' => ':count mandatów',
    'na' => 'N/D',
    'na_proportional_winner' => 'Metody proporcjonalne wybierają wiele mandatów, nie jednego zwycięzcę.',
    'na_informational_winner' => 'Metody informacyjne identyfikują zbiór kandydatów, nie ranking.',
    'na_proportional_loser' => 'Metody proporcjonalne wybierają wiele mandatów, nie jednego przegranego.',
    'na_informational_loser' => 'Metody informacyjne identyfikują zbiór kandydatów, nie ranking.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proporcjonalne · :seats mandatów',
    'rank' => 'Pozycja',
    'candidates_header' => 'Kandydaci',
    'tied_candidates' => 'Kandydaci ex aequo',
    'computation_statistics' => 'Statystyki obliczeń',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Macierz porównań parami',
    'pairwise_desc' => 'Każda komórka pokazuje <span class="font-semibold text-green-600 dark:text-green-400">zwycięstwa</span> / <span class="font-semibold text-red-600 dark:text-red-400">porażki</span> kandydata w wierszu wobec kandydata w kolumnie.',
    'vs' => 'vs.',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'Nazwa kandydata nie może być pusta.',
    'error_candidate_exists' => 'Wszyscy kandydaci już istnieją lub wpis jest nieprawidłowy.',
    'error_vote_empty' => 'Ranking głosu nie może być pusty.',
    'error_import_empty' => 'Najpierw wklej zawartość w formacie .cvotes.',
    'error_import_failed' => 'Import nie powiódł się: :message',
    'error_file_import_failed' => 'Import pliku nie powiódł się: :message',
    'error_export_min_candidates' => 'Potrzeba co najmniej 2 kandydatów do eksportu.',
    'error_export_build_failed' => 'Nie udało się zbudować wyborów.',
    'error_export_failed' => 'Eksport nie powiódł się: :message',
    'warning_vote_error' => 'Błąd głosu: :message',
    'warning_pairwise_error' => 'Błąd porównania parami: :message',
    'error_parse_votes_empty' => 'Wprowadź co najmniej jedną linię głosu.',
    'error_parse_votes_need_candidates' => 'Dodaj co najmniej 2 kandydatów przed hurtowym dodawaniem głosów.',
    'error_parse_votes_failed' => 'Nie udało się przeanalizować głosów: :message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Obliczanie…',
    'loading' => 'Ładowanie wyborów…',
    'processing_time' => ':time',

];
