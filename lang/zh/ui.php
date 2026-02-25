<?php

/**
 * Chinese (Simplified) UI translations for Condorcet Desktop.
 *
 * Organised by view/section. Keys are prefixed by area:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => '切换到浅色模式',
    'switch_to_dark' => '切换到深色模式',

    // ──────────────────────────────────────────────
    // About menu (app.blade.php)
    // ──────────────────────────────────────────────

    'about' => '关于',
    'view_on_github' => '在 GitHub 上查看',
    'donate' => '捐赠',
    'condorcet_wikipedia' => '孔多塞投票法',
    'created_by' => '作者',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => '选举进行中',
    'reset' => '重置',
    'confirm_reset' => '您确定要重置整个选举吗？',
    'warnings' => '警告',
    'see_results' => '查看结果',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => '候选人',
    'add' => '添加',
    'candidate_placeholder' => 'Alice 或 Alice ; Bob ; Charlie',
    'candidate_hint' => '使用分号一次添加多个候选人',
    'no_candidates' => '暂无候选人。',
    'remove_candidate' => '移除 :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => '投票',
    'weight' => '权重',
    'quantity' => '数量',
    'add_vote' => '添加投票',
    'vote_placeholder' => 'Alice > Bob > Charlie  或  Alice = Bob > Charlie',
    'weight_auto' => '默认',
    'vote_entries' => ':count 条投票记录',
    'total_weight' => '总权重：',
    'no_votes' => '暂无投票。',
    'remove_vote' => '移除投票',
    'bulk_add_votes' => '批量添加投票…',
    'parse_votes_title' => '批量添加投票',
    'parse_votes_desc' => '每行输入一张投票。格式：<code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^权重 * 数量</code>。以 <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> 开头的行将被忽略。',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => '添加投票',
    'cancel' => '取消',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => '配置',
    'implicit_ranking' => '隐式排名',
    'implicit_ranking_desc' => '启用时，未排名的候选人隐式并列在最后一位。禁用时，他们不获得任何分数。',
    'allow_vote_weight' => '允许投票权重',
    'allow_vote_weight_desc' => '启用时，每张选票可以携带不同的权重来放大其影响力。',
    'no_tie_constraint' => '禁止并列约束',
    'no_tie_constraint_desc' => '拒绝包含并列的投票。推荐用于某些比例代表制方法（STV）。',
    'number_of_seats' => '席位数',
    'seats_desc' => '比例代表制方法所需（STV、D\'Hondt、Sainte-Laguë 等）。',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => '投票方法',
    'method_options' => '方法选项',
    'group_single_winner' => '单一获胜者',
    'group_proportional' => '比例代表制',
    'group_informational' => '信息性',
    'borda_starting' => 'Borda 起始分',
    'borda_standard' => '1（标准）',
    'kemeny_max' => 'Kemeny–Young 最大候选人数',
    'kemeny_placeholder' => '10（留空表示无限制）',
    'kemeny_slow_warning' => '超过10个候选人时计算会非常缓慢。',
    'stv_quota' => 'STV 配额',
    'cpo_stv_quota' => 'CPO-STV 配额',
    'sainte_lague_divisor' => 'Sainte-Laguë 首除数',
    'sainte_lague_hint' => '1 = 标准 · 1.4 = 挪威变体',
    'largest_remainder_quota' => '最大余额配额',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => '导入 / 导出',
    'import_cvotes' => '从 .cvotes 格式导入',
    'export_cvotes' => '导出为 .cvotes 格式',
    'import' => '导入',
    'import_file' => '导入文件',
    'uploading' => '上传中…',
    'replace_warning' => '这将替换所有当前数据',
    'generate_export' => '生成导出',
    'copy' => '复制',
    'copied' => '已复制！',
    'download_cvotes' => '下载 .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => '无结果显示',
    'no_results_hint' => '添加至少 <strong>2 个候选人</strong> 和 <strong>1 张选票</strong> 来计算结果。',
    'no_results_methods_hint' => '然后选择一个或多个 <strong>投票方法</strong>。',
    'condorcet_winner' => 'Condorcet 获胜者',
    'condorcet_loser' => 'Condorcet 失败者',
    'none' => '无',
    'no_condorcet_winner_tooltip' => '没有候选人在所有两两比较中胜出。这意味着投票者偏好存在循环或平局。',
    'no_condorcet_loser_tooltip' => '没有候选人在所有两两比较中落败。这意味着投票者偏好存在循环或平局。',
    'election_label' => '选举',
    'n_candidates' => ':count 个候选人',
    'valid_votes' => '有效投票',
    'valid_weight' => '有效权重：',
    'overview' => '总览',
    'pairwise_matrix_tab' => '两两比较矩阵',
    'votes_tab' => '投票',
    'votes_list_heading' => '所有投票',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => '各方法对获胜者意见不一致。',
    'methods_disagree_desc' => '不同的投票方法可能产生不同的结果——这是社会选择理论的核心观点。',
    'method' => '方法',
    'winner' => '获胜者',
    'loser' => '失败者',
    'full_ranking' => '完整排名',
    'n_seats' => ':count 个席位',
    'na' => '不适用',
    'na_proportional_winner' => '比例代表制方法选出多个席位，而非单一获胜者。',
    'na_informational_winner' => '信息性方法识别一组候选人，而非排名。',
    'na_proportional_loser' => '比例代表制方法选出多个席位，而非单一失败者。',
    'na_informational_loser' => '信息性方法识别一组候选人，而非排名。',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => '比例代表制 · :seats 个席位',
    'rank' => '排名',
    'candidates_header' => '候选人',
    'tied_candidates' => '并列候选人',
    'computation_statistics' => '计算统计',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => '两两比较矩阵',
    'pairwise_desc' => '每个单元格显示行候选人对列候选人的 :wins / :losses。',
    'pairwise_wins' => '胜',
    'pairwise_losses' => '负',
    'vs' => '对',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => '候选人名称不能为空。',
    'error_candidate_exists' => '所有候选人已存在或输入无效。',
    'error_vote_empty' => '投票排名不能为空。',
    'error_import_empty' => '请先粘贴一些 .cvotes 内容。',
    'error_import_failed' => '导入失败：:message',
    'error_file_import_failed' => '文件导入失败：:message',
    'error_export_min_candidates' => '至少需要2个候选人才能导出。',
    'error_export_build_failed' => '无法构建选举。',
    'error_export_failed' => '导出失败：:message',
    'warning_vote_error' => '投票错误：:message',
    'warning_pairwise_error' => '两两比较错误：:message',
    'error_parse_votes_empty' => '请至少输入一行投票。',
    'error_parse_votes_need_candidates' => '批量添加投票前请至少添加2个候选人。',
    'error_parse_votes_failed' => '解析投票失败：:message',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => '正在计算…',
    'loading' => '正在加载选举…',
    'processing_time' => ':time',
    'reset_during_loading' => '重置选举',

];
