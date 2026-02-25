<?php

/**
 * Traducciones al español de la interfaz Condorcet Desktop.
 *
 * Organizadas por vista/sección. Las claves están prefijadas por área:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Cambiar a modo claro',
    'switch_to_dark' => 'Cambiar a modo oscuro',

    // ──────────────────────────────────────────────
    // About menu (app.blade.php)
    // ──────────────────────────────────────────────

    'about' => 'Acerca de',
    'view_on_github' => 'Ver en GitHub',
    'donate' => 'Donar',
    'condorcet_wikipedia' => 'Método de Condorcet (Wikipedia)',
    'created_by' => 'Creado por',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Elección en curso',
    'reset' => 'Reiniciar',
    'confirm_reset' => '¿Está seguro de que desea reiniciar toda la elección?',
    'warnings' => 'Advertencias',
    'see_results' => 'Ver resultados',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Candidatos',
    'add' => 'Añadir',
    'candidate_placeholder' => 'Alice o Alice ; Bob ; Charlie',
    'candidate_hint' => 'Use puntos y coma para añadir varios a la vez',
    'no_candidates' => 'Aún no hay candidatos.',
    'remove_candidate' => 'Eliminar :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Votos',
    'weight' => 'Peso',
    'quantity' => 'Cantidad',
    'add_vote' => 'Añadir voto',
    'vote_placeholder' => 'Alice > Bob > Charlie  o  Alice = Bob > Charlie',
    'weight_auto' => 'predeterminado',
    'vote_entries' => ':count papeleta|:count papeletas',
    'total_weight' => 'peso total:',
    'no_votes' => 'Aún no hay votos.',
    'remove_vote' => 'Eliminar voto',
    'bulk_add_votes' => 'Añadir votos en bloque…',
    'parse_votes_title' => 'Añadir votos en bloque',
    'parse_votes_desc' => 'Introduzca varios votos, uno por línea. Formato: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^peso * cantidad</code>. Las líneas que empiezan con <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> se ignoran.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Añadir votos',
    'cancel' => 'Cancelar',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Configuración',
    'implicit_ranking' => 'Clasificación implícita',
    'implicit_ranking_desc' => 'Cuando está activado, los candidatos no clasificados quedan implícitamente empatados en la última posición. Cuando está desactivado, no reciben puntos.',
    'allow_vote_weight' => 'Permitir ponderación de votos',
    'allow_vote_weight_desc' => 'Cuando está activado, cada voto puede tener un peso diferente que amplifica su influencia.',
    'no_tie_constraint' => 'Restricción sin empate',
    'no_tie_constraint_desc' => 'Rechazar votos que contengan empates. Recomendado para algunos métodos proporcionales (STV).',
    'number_of_seats' => 'Número de escaños',
    'seats_desc' => 'Requerido para métodos proporcionales (STV, D\'Hondt, Sainte-Laguë, etc.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Métodos de votación',
    'method_options' => 'Opciones de métodos',
    'group_single_winner' => 'Ganador único',
    'group_proportional' => 'Proporcional',
    'group_informational' => 'Informativo',
    'borda_starting' => 'Punto de inicio Borda',
    'borda_standard' => '1 (estándar)',
    'kemeny_max' => 'Kemeny–Young máx. candidatos',
    'kemeny_placeholder' => '10 (vacío = sin límite)',
    'kemeny_slow_warning' => 'El cálculo se vuelve muy lento por encima de 10 candidatos.',
    'stv_quota' => 'Cuota STV',
    'cpo_stv_quota' => 'Cuota CPO-STV',
    'sainte_lague_divisor' => 'Primer divisor Sainte-Laguë',
    'sainte_lague_hint' => '1 = estándar · 1.4 = variante noruega',
    'largest_remainder_quota' => 'Cuota restos mayores',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Importar / Exportar',
    'import_cvotes' => 'Importar desde formato .cvotes',
    'export_cvotes' => 'Exportar a formato .cvotes',
    'import' => 'Importar',
    'import_file' => 'Importar archivo',
    'uploading' => 'Subiendo…',
    'replace_warning' => 'Esto reemplazará todos los datos actuales',
    'generate_export' => 'Generar exportación',
    'copy' => 'Copiar',
    'copied' => '¡Copiado!',
    'download_cvotes' => 'Descargar .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'No hay resultados que mostrar',
    'no_results_hint' => 'Añada al menos <strong>2 candidatos</strong> y <strong>1 voto</strong> para calcular los resultados.',
    'no_results_methods_hint' => 'Luego seleccione uno o más <strong>métodos de votación</strong>.',
    'condorcet_winner' => 'Ganador de Condorcet',
    'condorcet_loser' => 'Perdedor de Condorcet',
    'none' => 'Ninguno',
    'no_condorcet_winner_tooltip' => 'Ningún candidato vence a todos los demás en comparación por pares. Esto significa que hay un ciclo o empate en las preferencias de los votantes.',
    'no_condorcet_loser_tooltip' => 'Ningún candidato pierde contra todos los demás en comparación por pares. Esto significa que hay un ciclo o empate en las preferencias de los votantes.',
    'election_label' => 'Elección',
    'n_candidates' => ':count candidato|:count candidatos',
    'valid_votes' => 'votos válidos',
    'valid_weight' => 'peso válido:',
    'overview' => 'Resumen',
    'pairwise_matrix_tab' => 'Matriz de comparación',
    'votes_tab' => 'Votos',
    'votes_list_heading' => 'Todos los votos',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Los métodos no coinciden en el ganador.',
    'methods_disagree_desc' => 'Diferentes métodos de votación pueden producir resultados diferentes: esta es la enseñanza fundamental de la teoría de la elección social.',
    'method' => 'Método',
    'winner' => 'Ganador',
    'loser' => 'Perdedor',
    'full_ranking' => 'Clasificación completa',
    'n_seats' => ':count escaños',
    'na' => 'N/A',
    'na_proportional_winner' => 'Los métodos proporcionales eligen varios escaños, no un solo ganador.',
    'na_informational_winner' => 'Los métodos informativos identifican un conjunto de candidatos, no una clasificación.',
    'na_proportional_loser' => 'Los métodos proporcionales eligen varios escaños, no un solo perdedor.',
    'na_informational_loser' => 'Los métodos informativos identifican un conjunto de candidatos, no una clasificación.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Proporcional · :seats escaños',
    'rank' => 'Rango',
    'candidates_header' => 'Candidatos',
    'tied_candidates' => 'Candidatos empatados',
    'computation_statistics' => 'Estadísticas de cálculo',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Matriz de comparación por pares',
    'pairwise_desc' => 'Cada celda muestra las :wins / :losses del candidato en fila contra el candidato en columna.',
    'pairwise_wins' => 'victorias',
    'pairwise_losses' => 'derrotas',
    'vs' => 'vs.',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'El nombre del candidato no puede estar vacío.',
    'error_candidate_exists' => 'Todos los candidatos ya existen o la entrada es inválida.',
    'error_vote_empty' => 'La clasificación del voto no puede estar vacía.',
    'error_import_empty' => 'Pegue primero contenido en formato .cvotes.',
    'error_import_failed' => 'Error en la importación: :message',
    'error_file_import_failed' => 'Error en la importación del archivo: :message',
    'error_export_min_candidates' => 'Se necesitan al menos 2 candidatos para exportar.',
    'error_export_build_failed' => 'No se pudo construir la elección.',
    'error_export_failed' => 'Error en la exportación: :message',
    'warning_vote_error' => 'Error de voto: :message',
    'warning_pairwise_error' => 'Error de comparación por pares: :message',
    'error_parse_votes_empty' => 'Introduzca al menos una línea de voto.',
    'error_parse_votes_need_candidates' => 'Añada al menos 2 candidatos antes de añadir votos en bloque.',
    'error_parse_votes_failed' => 'Error al analizar los votos: :message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Calculando…',
    'loading' => 'Cargando elección…',
    'processing_time' => ':time',
    'reset_during_loading' => 'Restablecer elección',

];
