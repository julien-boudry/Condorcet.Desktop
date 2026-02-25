<?php

/**
 * České překlady rozhraní Condorcet Desktop.
 *
 * Uspořádáno podle zobrazení/sekce. Klíče jsou předřazeny oblastí:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Přepnout na světlý režim',
    'switch_to_dark' => 'Přepnout na tmavý režim',

    // ──────────────────────────────────────────────
    // About menu (app.blade.php)
    // ──────────────────────────────────────────────

    'about' => 'O aplikaci',
    'view_on_github' => 'Zobrazit na GitHubu',
    'donate' => 'Přispět',
    'created_by' => 'Vytvořil',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Probíhající volby',
    'reset' => 'Resetovat',
    'confirm_reset' => 'Opravdu chcete resetovat celé volby?',
    'warnings' => 'Upozornění',
    'see_results' => 'Zobrazit výsledky',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Kandidáti',
    'add' => 'Přidat',
    'candidate_placeholder' => 'Alice nebo Alice ; Bob ; Charlie',
    'candidate_hint' => 'Použijte středníky pro přidání více kandidátů najednou',
    'no_candidates' => 'Zatím žádní kandidáti.',
    'remove_candidate' => 'Odebrat :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Hlasy',
    'weight' => 'Váha',
    'quantity' => 'Množství',
    'add_vote' => 'Přidat hlas',
    'vote_placeholder' => 'Alice > Bob > Charlie  nebo  Alice = Bob > Charlie',
    'weight_auto' => 'výchozí',
    'vote_entries' => ':count hlas|:count hlasy|:count hlasů',
    'total_weight' => 'celková váha:',
    'no_votes' => 'Zatím žádné hlasy.',
    'remove_vote' => 'Odebrat hlas',
    'bulk_add_votes' => 'Hromadné přidání hlasů…',
    'parse_votes_title' => 'Hromadné přidání hlasů',
    'parse_votes_desc' => 'Zadejte více hlasů, jeden na řádek. Formát: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^váha * množství</code>. Řádky začínající <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> jsou ignorovány.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Přidat hlasy',
    'cancel' => 'Zrušit',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Nastavení',
    'implicit_ranking' => 'Implicitní pořadí',
    'implicit_ranking_desc' => 'Když je zapnuto, neseřazení kandidáti jsou implicitně na posledním místě se stejným pořadím. Když je vypnuto, nezískávají žádné body.',
    'allow_vote_weight' => 'Povolit váhu hlasů',
    'allow_vote_weight_desc' => 'Když je zapnuto, každý hlas může mít jinou váhu, která zesiluje jeho vliv.',
    'no_tie_constraint' => 'Omezení bez remízy',
    'no_tie_constraint_desc' => 'Odmítnout hlasy obsahující remízy. Doporučeno pro některé proporcionální metody (STV).',
    'number_of_seats' => 'Počet mandátů',
    'seats_desc' => 'Vyžadováno pro proporcionální metody (STV, D\'Hondt, Sainte-Laguë atd.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Volební metody',
    'method_options' => 'Možnosti metod',
    'group_single_winner' => 'Jeden vítěz',
    'group_proportional' => 'Proporcionální',
    'group_informational' => 'Informační',
    'borda_starting' => 'Počáteční bod Borda',
    'borda_standard' => '1 (standardní)',
    'kemeny_max' => 'Kemeny–Young max. kandidátů',
    'kemeny_placeholder' => '10 (prázdné = bez limitu)',
    'kemeny_slow_warning' => 'Výpočet se stává velmi pomalým nad 10 kandidátů.',
    'stv_quota' => 'Kvóta STV',
    'cpo_stv_quota' => 'Kvóta CPO-STV',
    'sainte_lague_divisor' => 'První dělitel Sainte-Laguë',
    'sainte_lague_hint' => '1 = standardní · 1.4 = norská varianta',
    'largest_remainder_quota' => 'Kvóta největších zbytků',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Import / Export',
    'import_cvotes' => 'Importovat z formátu .cvotes',
    'export_cvotes' => 'Exportovat do formátu .cvotes',
    'import' => 'Importovat',
    'import_file' => 'Importovat soubor',
    'uploading' => 'Nahrávání…',
    'replace_warning' => 'Tím se nahradí všechna aktuální data',
    'generate_export' => 'Generovat export',
    'copy' => 'Kopírovat',
    'copied' => 'Zkopírováno!',
    'download_cvotes' => 'Stáhnout .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'Žádné výsledky k zobrazení',
    'no_results_hint' => 'Přidejte alespoň <strong>2 kandidáty</strong> a <strong>1 hlas</strong> pro výpočet výsledků.',
    'no_results_methods_hint' => 'Poté vyberte jednu nebo více <strong>volebních metod</strong>.',
    'condorcet_winner' => 'Condorcetův vítěz',
    'condorcet_loser' => 'Condorcetův poražený',
    'none' => 'Žádný',
    'no_condorcet_winner_tooltip' => 'Žádný kandidát neporáží všechny ostatní v párovém srovnání. To znamená, že v preferencích voličů existuje cyklus nebo remíza.',
    'no_condorcet_loser_tooltip' => 'Žádný kandidát neprohrává se všemi ostatními v párovém srovnání. To znamená, že v preferencích voličů existuje cyklus nebo remíza.',
    'election_label' => 'Volby',
    'n_candidates' => ':count kandidát|:count kandidátů',
    'valid_votes' => 'platné hlasy',
    'valid_weight' => 'platná váha:',
    'overview' => 'Přehled',
    'pairwise_matrix_tab' => 'Matice porovnání',
    'votes_tab' => 'Hlasy',
    'votes_list_heading' => 'Všechny hlasy',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Metody se neshodují na vítězi.',
    'methods_disagree_desc' => 'Různé volební metody mohou poskytovat různé výsledky — to je základní poznatek teorie společenského výběru.',
    'method' => 'Metoda',
    'winner' => 'Vítěz',
    'loser' => 'Poražený',
    'full_ranking' => 'Úplné pořadí',
    'n_seats' => ':count mandátů',
    'na' => 'N/A',
    'na_proportional_winner' => 'Proporcionální metody volí více mandátů, nikoli jednoho vítěze.',
    'na_informational_winner' => 'Informační metody identifikují skupinu kandidátů, nikoli pořadí.',
    'na_proportional_loser' => 'Proporcionální metody volí více mandátů, nikoli jednoho poraženého.',
    'na_informational_loser' => 'Informační metody identifikují skupinu kandidátů, nikoli pořadí.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proporcionální · :seats mandátů',
    'rank' => 'Pořadí',
    'candidates_header' => 'Kandidáti',
    'tied_candidates' => 'Kandidáti v remíze',
    'computation_statistics' => 'Statistiky výpočtu',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Matice párového srovnání',
    'pairwise_desc' => 'Každá buňka ukazuje :wins / :losses kandidáta v řádku proti kandidátovi ve sloupci.',
    'pairwise_wins' => 'výhry',
    'pairwise_losses' => 'prohry',
    'vs' => 'vs.',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'Jméno kandidáta nemůže být prázdné.',
    'error_candidate_exists' => 'Všichni kandidáti již existují nebo je vstup neplatný.',
    'error_vote_empty' => 'Pořadí hlasu nemůže být prázdné.',
    'error_import_empty' => 'Nejprve vložte obsah ve formátu .cvotes.',
    'error_import_failed' => 'Import se nezdařil: :message',
    'error_file_import_failed' => 'Import souboru se nezdařil: :message',
    'error_export_min_candidates' => 'Pro export jsou potřeba alespoň 2 kandidáti.',
    'error_export_build_failed' => 'Nepodařilo se sestavit volby.',
    'error_export_failed' => 'Export se nezdařil: :message',
    'warning_vote_error' => 'Chyba hlasu: :message',
    'warning_pairwise_error' => 'Chyba párového srovnání: :message',
    'error_parse_votes_empty' => 'Zadejte alespoň jeden řádek hlasu.',
    'error_parse_votes_need_candidates' => 'Před hromadným přidáním hlasů přidejte alespoň 2 kandidáty.',
    'error_parse_votes_failed' => 'Nepodařilo se analyzovat hlasy: :message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Výpočet…',
    'loading' => 'Načítání voleb…',
    'processing_time' => ':time',
    'reset_during_loading' => 'Resetovat volby',

];
