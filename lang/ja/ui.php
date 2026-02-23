<?php

/**
 * Japanese UI translations for Condorcet Desktop.
 *
 * Organised by view/section. Keys are prefixed by area:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'ライトモードに切替',
    'switch_to_dark' => 'ダークモードに切替',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => '選挙進行中',
    'reset' => 'リセット',
    'confirm_reset' => '選挙全体をリセットしてもよろしいですか？',
    'warnings' => '警告',
    'see_results' => '結果を見る',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => '候補者',
    'add' => '追加',
    'candidate_placeholder' => 'Alice または Alice ; Bob ; Charlie',
    'candidate_hint' => 'セミコロンで複数を一度に追加',
    'no_candidates' => '候補者がまだいません。',
    'remove_candidate' => ':candidate を削除',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => '投票',
    'weight' => '重み',
    'quantity' => '数量',
    'add_vote' => '投票を追加',
    'vote_placeholder' => 'Alice > Bob > Charlie  または  Alice = Bob > Charlie',
    'weight_auto' => 'デフォルト',
    'vote_entries' => ':count 件の投票',
    'total_weight' => '合計重み：',
    'no_votes' => '投票がまだありません。',
    'remove_vote' => '投票を削除',
    'bulk_add_votes' => '一括投票追加…',
    'parse_votes_title' => '一括投票追加',
    'parse_votes_desc' => '1行に1票ずつ入力してください。形式：<code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^重み * 数量</code>。<code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> で始まる行は無視されます。',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => '投票を追加',
    'cancel' => 'キャンセル',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => '設定',
    'implicit_ranking' => '暗黙的順位付け',
    'implicit_ranking_desc' => '有効にすると、順位付けされていない候補者は暗黙的に最下位で同順位になります。無効の場合、ポイントは付与されません。',
    'allow_vote_weight' => '投票重みを許可',
    'allow_vote_weight_desc' => '有効にすると、各投票に異なる重みを設定して影響力を増減できます。',
    'no_tie_constraint' => '同順位禁止制約',
    'no_tie_constraint_desc' => '同順位を含む投票を拒否します。一部の比例代表制方式（STV）に推奨。',
    'number_of_seats' => '議席数',
    'seats_desc' => '比例代表制方式に必要（STV、D\'Hondt、Sainte-Laguë など）。',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => '投票方式',
    'method_options' => '方式オプション',
    'group_single_winner' => '単一勝者',
    'group_proportional' => '比例代表制',
    'group_informational' => '情報提供型',
    'borda_starting' => 'Borda 開始点',
    'borda_standard' => '1（標準）',
    'kemeny_max' => 'Kemeny–Young 最大候補者数',
    'kemeny_placeholder' => '10（空欄で制限なし）',
    'kemeny_slow_warning' => '候補者が10人を超えると計算が非常に遅くなります。',
    'stv_quota' => 'STV 基準値',
    'cpo_stv_quota' => 'CPO-STV 基準値',
    'sainte_lague_divisor' => 'Sainte-Laguë 初期除数',
    'sainte_lague_hint' => '1 = 標準 · 1.4 = ノルウェー方式',
    'largest_remainder_quota' => '最大剰余基準値',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'インポート / エクスポート',
    'import_cvotes' => '.cvotes 形式からインポート',
    'export_cvotes' => '.cvotes 形式にエクスポート',
    'import' => 'インポート',
    'import_file' => 'ファイルをインポート',
    'uploading' => 'アップロード中…',
    'replace_warning' => '現在のデータはすべて置き換えられます',
    'generate_export' => 'エクスポートを生成',
    'copy' => 'コピー',
    'copied' => 'コピー完了！',
    'download_cvotes' => '.cvotes をダウンロード',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => '表示する結果がありません',
    'no_results_hint' => '結果を計算するには、<strong>2人以上の候補者</strong>と<strong>1票以上</strong>を追加してください。',
    'no_results_methods_hint' => '次に、1つ以上の<strong>投票方式</strong>を選択してください。',
    'condorcet_winner' => 'Condorcet 勝者',
    'condorcet_loser' => 'Condorcet 敗者',
    'none' => 'なし',
    'no_condorcet_winner_tooltip' => 'すべての一対比較で勝つ候補者がいません。投票者の選好に循環またはタイがあることを意味します。',
    'no_condorcet_loser_tooltip' => 'すべての一対比較で負ける候補者がいません。投票者の選好に循環またはタイがあることを意味します。',
    'election_label' => '選挙',
    'n_candidates' => ':count 人の候補者',
    'valid_votes' => '有効投票',
    'valid_weight' => '有効重み：',
    'overview' => '概要',
    'pairwise_matrix_tab' => '一対比較行列',
    'votes_tab' => '投票',
    'votes_list_heading' => '全投票一覧',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => '方式間で勝者が異なります。',
    'methods_disagree_desc' => '異なる投票方式は異なる結果を生む可能性があります——これは社会選択理論の核心的知見です。',
    'method' => '方式',
    'winner' => '勝者',
    'loser' => '敗者',
    'full_ranking' => '完全順位',
    'n_seats' => ':count 議席',
    'na' => '該当なし',
    'na_proportional_winner' => '比例代表制方式は複数の議席を選出し、単一の勝者を選びません。',
    'na_informational_winner' => '情報提供型方式は候補者集合を特定し、順位付けは行いません。',
    'na_proportional_loser' => '比例代表制方式は複数の議席を選出し、単一の敗者を選びません。',
    'na_informational_loser' => '情報提供型方式は候補者集合を特定し、順位付けは行いません。',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => '比例代表制 · :seats 議席',
    'rank' => '順位',
    'candidates_header' => '候補者',
    'tied_candidates' => '同順位候補者',
    'computation_statistics' => '計算統計',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => '一対比較行列',
    'pairwise_desc' => '各セルは行候補者の列候補者に対する <span class="font-semibold text-green-600 dark:text-green-400">勝ち</span> / <span class="font-semibold text-red-600 dark:text-red-400">負け</span> を示します。',
    'vs' => '対',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => '候補者名を空にすることはできません。',
    'error_candidate_exists' => 'すべての候補者は既に存在するか、入力が無効です。',
    'error_vote_empty' => '投票順位を空にすることはできません。',
    'error_import_empty' => '先に .cvotes の内容を貼り付けてください。',
    'error_import_failed' => 'インポート失敗：:message',
    'error_file_import_failed' => 'ファイルインポート失敗：:message',
    'error_export_min_candidates' => 'エクスポートには少なくとも2人の候補者が必要です。',
    'error_export_build_failed' => '選挙を構築できませんでした。',
    'error_export_failed' => 'エクスポート失敗：:message',
    'warning_vote_error' => '投票エラー：:message',
    'warning_pairwise_error' => '一対比較エラー：:message',
    'error_parse_votes_empty' => '少なくとも1行の投票を入力してください。',
    'error_parse_votes_need_candidates' => '一括投票追加の前に少なくとも2人の候補者を追加してください。',
    'error_parse_votes_failed' => '投票の解析に失敗：:message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => '計算中…',
    'loading' => '選挙を読み込み中…',
    'processing_time' => ':time',

];
