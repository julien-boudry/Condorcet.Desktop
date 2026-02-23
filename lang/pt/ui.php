<?php

/**
 * Traduções em português da interface Condorcet Desktop.
 *
 * Organizadas por vista/secção. As chaves são prefixadas por área:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Mudar para modo claro',
    'switch_to_dark' => 'Mudar para modo escuro',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Eleição em andamento',
    'reset' => 'Reiniciar',
    'confirm_reset' => 'Tem a certeza de que deseja reiniciar toda a eleição?',
    'warnings' => 'Avisos',
    'see_results' => 'Ver resultados',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Candidatos',
    'add' => 'Adicionar',
    'candidate_placeholder' => 'Alice ou Alice ; Bob ; Charlie',
    'candidate_hint' => 'Use ponto e vírgula para adicionar vários de uma vez',
    'no_candidates' => 'Ainda não há candidatos.',
    'remove_candidate' => 'Remover :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Votos',
    'weight' => 'Peso',
    'quantity' => 'Quantidade',
    'add_vote' => 'Adicionar voto',
    'vote_placeholder' => 'Alice > Bob > Charlie  ou  Alice = Bob > Charlie',
    'weight_auto' => 'padrão',
    'vote_entries' => ':count boletim de voto|:count boletins de voto',
    'total_weight' => 'peso total:',
    'no_votes' => 'Ainda não há votos.',
    'remove_vote' => 'Remover voto',
    'bulk_add_votes' => 'Adicionar votos em massa…',
    'parse_votes_title' => 'Adicionar votos em massa',
    'parse_votes_desc' => 'Introduza vários votos, um por linha. Formato: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^peso * quantidade</code>. As linhas que começam com <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> são ignoradas.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Adicionar votos',
    'cancel' => 'Cancelar',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Configuração',
    'implicit_ranking' => 'Classificação implícita',
    'implicit_ranking_desc' => 'Quando ativado, os candidatos não classificados ficam implicitamente empatados na última posição. Quando desativado, não recebem pontos.',
    'allow_vote_weight' => 'Permitir ponderação de votos',
    'allow_vote_weight_desc' => 'Quando ativado, cada voto pode ter um peso diferente que amplifica a sua influência.',
    'no_tie_constraint' => 'Restrição sem empate',
    'no_tie_constraint_desc' => 'Rejeitar votos que contenham empates. Recomendado para alguns métodos proporcionais (STV).',
    'number_of_seats' => 'Número de lugares',
    'seats_desc' => 'Necessário para métodos proporcionais (STV, D\'Hondt, Sainte-Laguë, etc.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Métodos de votação',
    'method_options' => 'Opções dos métodos',
    'group_single_winner' => 'Vencedor único',
    'group_proportional' => 'Proporcional',
    'group_informational' => 'Informativo',
    'borda_starting' => 'Ponto de partida Borda',
    'borda_standard' => '1 (padrão)',
    'kemeny_max' => 'Kemeny–Young máx. candidatos',
    'kemeny_placeholder' => '10 (vazio = sem limite)',
    'kemeny_slow_warning' => 'O cálculo torna-se muito lento acima de 10 candidatos.',
    'stv_quota' => 'Quota STV',
    'cpo_stv_quota' => 'Quota CPO-STV',
    'sainte_lague_divisor' => 'Primeiro divisor Sainte-Laguë',
    'sainte_lague_hint' => '1 = padrão · 1.4 = variante norueguesa',
    'largest_remainder_quota' => 'Quota maiores restos',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Importar / Exportar',
    'import_cvotes' => 'Importar do formato .cvotes',
    'export_cvotes' => 'Exportar para formato .cvotes',
    'import' => 'Importar',
    'import_file' => 'Importar ficheiro',
    'uploading' => 'A enviar…',
    'replace_warning' => 'Isto substituirá todos os dados atuais',
    'generate_export' => 'Gerar exportação',
    'copy' => 'Copiar',
    'copied' => 'Copiado!',
    'download_cvotes' => 'Descarregar .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'Sem resultados para apresentar',
    'no_results_hint' => 'Adicione pelo menos <strong>2 candidatos</strong> e <strong>1 voto</strong> para calcular os resultados.',
    'no_results_methods_hint' => 'Depois selecione um ou mais <strong>métodos de votação</strong>.',
    'condorcet_winner' => 'Vencedor de Condorcet',
    'condorcet_loser' => 'Perdedor de Condorcet',
    'none' => 'Nenhum',
    'no_condorcet_winner_tooltip' => 'Nenhum candidato vence todos os outros em comparação por pares. Isto significa que há um ciclo ou empate nas preferências dos eleitores.',
    'no_condorcet_loser_tooltip' => 'Nenhum candidato perde contra todos os outros em comparação por pares. Isto significa que há um ciclo ou empate nas preferências dos eleitores.',
    'election_label' => 'Eleição',
    'n_candidates' => ':count candidato|:count candidatos',
    'valid_votes' => 'votos válidos',
    'valid_weight' => 'peso válido:',
    'overview' => 'Visão geral',
    'pairwise_matrix_tab' => 'Matriz de comparação',
    'votes_tab' => 'Votos',
    'votes_list_heading' => 'Todos os votos',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Os métodos não concordam sobre o vencedor.',
    'methods_disagree_desc' => 'Diferentes métodos de votação podem produzir resultados diferentes — este é o ensinamento fundamental da teoria da escolha social.',
    'method' => 'Método',
    'winner' => 'Vencedor',
    'loser' => 'Perdedor',
    'full_ranking' => 'Classificação completa',
    'n_seats' => ':count lugares',
    'na' => 'N/A',
    'na_proportional_winner' => 'Os métodos proporcionais elegem vários lugares, não um único vencedor.',
    'na_informational_winner' => 'Os métodos informativos identificam um conjunto de candidatos, não uma classificação.',
    'na_proportional_loser' => 'Os métodos proporcionais elegem vários lugares, não um único perdedor.',
    'na_informational_loser' => 'Os métodos informativos identificam um conjunto de candidatos, não uma classificação.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proporcional · :seats lugares',
    'rank' => 'Posição',
    'candidates_header' => 'Candidatos',
    'tied_candidates' => 'Candidatos empatados',
    'computation_statistics' => 'Estatísticas de cálculo',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Matriz de comparação por pares',
    'pairwise_desc' => 'Cada célula mostra as <span class="font-semibold text-green-600 dark:text-green-400">vitórias</span> / <span class="font-semibold text-red-600 dark:text-red-400">derrotas</span> do candidato na linha contra o candidato na coluna.',
    'vs' => 'vs.',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'O nome do candidato não pode estar vazio.',
    'error_candidate_exists' => 'Todos os candidatos já existem ou a entrada é inválida.',
    'error_vote_empty' => 'A classificação do voto não pode estar vazia.',
    'error_import_empty' => 'Cole primeiro conteúdo no formato .cvotes.',
    'error_import_failed' => 'Falha na importação: :message',
    'error_file_import_failed' => 'Falha na importação do ficheiro: :message',
    'error_export_min_candidates' => 'São necessários pelo menos 2 candidatos para exportar.',
    'error_export_build_failed' => 'Não foi possível construir a eleição.',
    'error_export_failed' => 'Falha na exportação: :message',
    'warning_vote_error' => 'Erro de voto: :message',
    'warning_pairwise_error' => 'Erro de comparação por pares: :message',
    'error_parse_votes_empty' => 'Introduza pelo menos uma linha de voto.',
    'error_parse_votes_need_candidates' => 'Adicione pelo menos 2 candidatos antes de adicionar votos em massa.',
    'error_parse_votes_failed' => 'Falha ao analisar os votos: :message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'A calcular…',
    'loading' => 'A carregar eleição…',
    'processing_time' => ':time',

];
