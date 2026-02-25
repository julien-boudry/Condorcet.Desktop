<?php

/**
 * Русские переводы интерфейса Condorcet Desktop.
 *
 * Организованы по представлению/разделу. Ключи именуются по области:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'Переключить на светлую тему',
    'switch_to_dark' => 'Переключить на тёмную тему',

    // ──────────────────────────────────────────────
    // About menu (app.blade.php)
    // ──────────────────────────────────────────────

    'about' => 'О приложении',
    'view_on_github' => 'Смотреть на GitHub',
    'donate' => 'Пожертвовать',
    'created_by' => 'Автор',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'Выборы в процессе',
    'reset' => 'Сбросить',
    'confirm_reset' => 'Вы уверены, что хотите сбросить все выборы?',
    'warnings' => 'Предупреждения',
    'see_results' => 'Показать результаты',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'Кандидаты',
    'add' => 'Добавить',
    'candidate_placeholder' => 'Алиса или Алиса ; Боб ; Чарли',
    'candidate_hint' => 'Используйте точку с запятой для добавления нескольких кандидатов',
    'no_candidates' => 'Кандидатов пока нет.',
    'remove_candidate' => 'Удалить :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'Голоса',
    'weight' => 'Вес',
    'quantity' => 'Количество',
    'add_vote' => 'Добавить голос',
    'vote_placeholder' => 'Alice > Bob > Charlie  или  Alice = Bob > Charlie',
    'weight_auto' => 'по умолчанию',
    'vote_entries' => ':count голос|:count голоса|:count голосов',
    'total_weight' => 'общий вес:',
    'no_votes' => 'Голосов пока нет.',
    'remove_vote' => 'Удалить голос',
    'bulk_add_votes' => 'Массовое добавление голосов…',
    'parse_votes_title' => 'Массовое добавление голосов',
    'parse_votes_desc' => 'Введите несколько голосов, по одному на строку. Формат: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^вес * количество</code>. Строки, начинающиеся с <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code>, игнорируются.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'Добавить голоса',
    'cancel' => 'Отмена',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'Настройки',
    'implicit_ranking' => 'Неявное ранжирование',
    'implicit_ranking_desc' => 'Если включено, неранжированные кандидаты неявно занимают последнее место с одинаковым рангом. Если выключено, они не получают очков.',
    'allow_vote_weight' => 'Разрешить вес голосов',
    'allow_vote_weight_desc' => 'Если включено, каждый голос может иметь разный вес, усиливающий его влияние.',
    'no_tie_constraint' => 'Ограничение без ничьей',
    'no_tie_constraint_desc' => 'Отклонять голоса, содержащие ничьи. Рекомендуется для некоторых пропорциональных методов (STV).',
    'number_of_seats' => 'Количество мест',
    'seats_desc' => 'Требуется для пропорциональных методов (STV, Д\'Ондт, Сент-Лагю и др.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'Методы голосования',
    'method_options' => 'Параметры методов',
    'group_single_winner' => 'Один победитель',
    'group_proportional' => 'Пропорциональные',
    'group_informational' => 'Информационные',
    'borda_starting' => 'Начальная точка Борда',
    'borda_standard' => '1 (стандартная)',
    'kemeny_max' => 'Kemeny–Young макс. кандидатов',
    'kemeny_placeholder' => '10 (пусто = без ограничения)',
    'kemeny_slow_warning' => 'Вычисление становится очень медленным при более чем 10 кандидатах.',
    'stv_quota' => 'Квота STV',
    'cpo_stv_quota' => 'Квота CPO-STV',
    'sainte_lague_divisor' => 'Первый делитель Сент-Лагю',
    'sainte_lague_hint' => '1 = стандартный · 1.4 = норвежский вариант',
    'largest_remainder_quota' => 'Квота наибольших остатков',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'Импорт / Экспорт',
    'import_cvotes' => 'Импорт из формата .cvotes',
    'export_cvotes' => 'Экспорт в формат .cvotes',
    'import' => 'Импорт',
    'import_file' => 'Импортировать файл',
    'uploading' => 'Загрузка…',
    'replace_warning' => 'Это заменит все текущие данные',
    'generate_export' => 'Сгенерировать экспорт',
    'copy' => 'Копировать',
    'copied' => 'Скопировано!',
    'download_cvotes' => 'Скачать .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'Нет результатов для отображения',
    'no_results_hint' => 'Добавьте как минимум <strong>2 кандидатов</strong> и <strong>1 голос</strong> для вычисления результатов.',
    'no_results_methods_hint' => 'Затем выберите один или несколько <strong>методов голосования</strong>.',
    'condorcet_winner' => 'Победитель Кондорсе',
    'condorcet_loser' => 'Проигравший Кондорсе',
    'none' => 'Нет',
    'no_condorcet_winner_tooltip' => 'Ни один кандидат не побеждает всех остальных в попарном сравнении. Это означает наличие цикла или ничьей в предпочтениях избирателей.',
    'no_condorcet_loser_tooltip' => 'Ни один кандидат не проигрывает всем остальным в попарном сравнении. Это означает наличие цикла или ничьей в предпочтениях избирателей.',
    'election_label' => 'Выборы',
    'n_candidates' => ':count кандидат|:count кандидатов',
    'valid_votes' => 'действительные голоса',
    'valid_weight' => 'действительный вес:',
    'overview' => 'Обзор',
    'pairwise_matrix_tab' => 'Матрица сравнений',
    'votes_tab' => 'Голоса',
    'votes_list_heading' => 'Все голоса',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'Методы расходятся в определении победителя.',
    'methods_disagree_desc' => 'Разные методы голосования могут давать разные результаты — это ключевое открытие теории общественного выбора.',
    'method' => 'Метод',
    'winner' => 'Победитель',
    'loser' => 'Проигравший',
    'full_ranking' => 'Полное ранжирование',
    'n_seats' => ':count мест',
    'na' => 'Н/Д',
    'na_proportional_winner' => 'Пропорциональные методы избирают несколько мест, а не одного победителя.',
    'na_informational_winner' => 'Информационные методы определяют набор кандидатов, а не ранжирование.',
    'na_proportional_loser' => 'Пропорциональные методы избирают несколько мест, а не одного проигравшего.',
    'na_informational_loser' => 'Информационные методы определяют набор кандидатов, а не ранжирование.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'Пропорциональный · :seats мест',
    'rank' => 'Ранг',
    'candidates_header' => 'Кандидаты',
    'tied_candidates' => 'Кандидаты с ничьей',
    'computation_statistics' => 'Статистика вычислений',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'Матрица попарных сравнений',
    'pairwise_desc' => 'Каждая ячейка показывает :wins / :losses кандидата в строке против кандидата в столбце.',
    'pairwise_wins' => 'победы',
    'pairwise_losses' => 'поражения',
    'vs' => 'vs.',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'Имя кандидата не может быть пустым.',
    'error_candidate_exists' => 'Все кандидаты уже существуют или ввод недействителен.',
    'error_vote_empty' => 'Ранжирование голоса не может быть пустым.',
    'error_import_empty' => 'Сначала вставьте содержимое в формате .cvotes.',
    'error_import_failed' => 'Ошибка импорта: :message',
    'error_file_import_failed' => 'Ошибка импорта файла: :message',
    'error_export_min_candidates' => 'Для экспорта необходимо минимум 2 кандидата.',
    'error_export_build_failed' => 'Не удалось построить выборы.',
    'error_export_failed' => 'Ошибка экспорта: :message',
    'warning_vote_error' => 'Ошибка голоса: :message',
    'warning_pairwise_error' => 'Ошибка попарного сравнения: :message',
    'error_parse_votes_empty' => 'Введите хотя бы одну строку голоса.',
    'error_parse_votes_need_candidates' => 'Добавьте минимум 2 кандидатов перед массовым добавлением голосов.',
    'error_parse_votes_failed' => 'Не удалось разобрать голоса: :message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'Вычисление…',
    'loading' => 'Загрузка выборов…',
    'processing_time' => ':time',
    'reset_during_loading' => 'Сбросить выборы',

];
