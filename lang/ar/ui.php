<?php

/**
 * الترجمة العربية لواجهة Condorcet Desktop.
 *
 * منظّمة حسب العرض/القسم. المفاتيح مسبوقة بالمنطقة:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'switch_to_light' => 'التبديل إلى الوضع الفاتح',
    'switch_to_dark' => 'التبديل إلى الوضع الداكن',

    // ──────────────────────────────────────────────
    // About menu (app.blade.php)
    // ──────────────────────────────────────────────

    'about' => 'حول',
    'view_on_github' => 'عرض على GitHub',
    'donate' => 'تبرع',
    'condorcet_wikipedia' => 'طريقة كوندورسيه',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'انتخابات جارية',
    'reset' => 'إعادة تعيين',
    'confirm_reset' => 'هل أنت متأكد أنك تريد إعادة تعيين الانتخابات بالكامل؟',
    'warnings' => 'تحذيرات',
    'see_results' => 'عرض النتائج',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'المرشحون',
    'add' => 'إضافة',
    'candidate_placeholder' => 'أليس أو أليس ; بوب ; تشارلي',
    'candidate_hint' => 'استخدم الفاصلة المنقوطة لإضافة عدة مرشحين دفعة واحدة',
    'no_candidates' => 'لا يوجد مرشحون بعد.',
    'remove_candidate' => 'إزالة :candidate',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'الأصوات',
    'weight' => 'الوزن',
    'quantity' => 'الكمية',
    'add_vote' => 'إضافة صوت',
    'vote_placeholder' => 'أليس > بوب > تشارلي  أو  أليس = بوب > تشارلي',
    'weight_auto' => 'افتراضي',
    'vote_entries' => ':count صوت|:count أصوات',
    'total_weight' => 'الوزن الإجمالي:',
    'no_votes' => 'لا توجد أصوات بعد.',
    'remove_vote' => 'إزالة الصوت',
    'bulk_add_votes' => 'إضافة أصوات بالجملة…',
    'parse_votes_title' => 'إضافة أصوات بالجملة',
    'parse_votes_desc' => 'أدخل عدة أصوات، واحد في كل سطر. الصيغة: <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">A > B > C ^وزن * كمية</code>. الأسطر التي تبدأ بـ <code class="bg-gray-100 dark:bg-gray-800 px-1 rounded">#</code> يتم تجاهلها.',
    'parse_votes_placeholder' => "Alice > Bob > Charlie\nBob > Alice > Charlie ^2\nCharlie > Alice > Bob * 3",
    'parse_votes_submit' => 'إضافة الأصوات',
    'cancel' => 'إلغاء',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'الإعدادات',
    'implicit_ranking' => 'الترتيب الضمني',
    'implicit_ranking_desc' => 'عند التفعيل، يُوضع المرشحون غير المصنّفين ضمنيًا في المرتبة الأخيرة بالتساوي. عند التعطيل، لا يحصلون على أي نقاط.',
    'allow_vote_weight' => 'السماح بترجيح الأصوات',
    'allow_vote_weight_desc' => 'عند التفعيل، يمكن لكل صوت أن يحمل وزنًا مختلفًا يضاعف تأثيره.',
    'no_tie_constraint' => 'قيد منع التعادل',
    'no_tie_constraint_desc' => 'رفض الأصوات التي تحتوي على تعادلات. مُوصى به لبعض الطرق التناسبية (STV).',
    'number_of_seats' => 'عدد المقاعد',
    'seats_desc' => 'مطلوب للطرق التناسبية (STV، D\'Hondt، Sainte-Laguë، إلخ.).',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'طرق التصويت',
    'method_options' => 'خيارات الطرق',
    'group_single_winner' => 'فائز واحد',
    'group_proportional' => 'تناسبي',
    'group_informational' => 'معلوماتي',
    'borda_starting' => 'نقطة بداية بوردا',
    'borda_standard' => '1 (قياسي)',
    'kemeny_max' => 'Kemeny–Young الحد الأقصى للمرشحين',
    'kemeny_placeholder' => '10 (فارغ = بدون حد)',
    'kemeny_slow_warning' => 'يصبح الحساب بطيئًا جدًا فوق 10 مرشحين.',
    'stv_quota' => 'حصة STV',
    'cpo_stv_quota' => 'حصة CPO-STV',
    'sainte_lague_divisor' => 'المقسوم الأول Sainte-Laguë',
    'sainte_lague_hint' => '1 = قياسي · 1.4 = البديل النرويجي',
    'largest_remainder_quota' => 'حصة أكبر الباقي',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'استيراد / تصدير',
    'import_cvotes' => 'استيراد من صيغة .cvotes',
    'export_cvotes' => 'تصدير إلى صيغة .cvotes',
    'import' => 'استيراد',
    'import_file' => 'استيراد ملف',
    'uploading' => 'جارٍ الرفع…',
    'replace_warning' => 'سيؤدي هذا إلى استبدال جميع البيانات الحالية',
    'generate_export' => 'إنشاء التصدير',
    'copy' => 'نسخ',
    'copied' => 'تم النسخ!',
    'download_cvotes' => 'تنزيل .cvotes',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'لا توجد نتائج لعرضها',
    'no_results_hint' => 'أضف على الأقل <strong>مرشحَين</strong> و<strong>صوتًا واحدًا</strong> لحساب النتائج.',
    'no_results_methods_hint' => 'ثم اختر <strong>طريقة تصويت</strong> واحدة أو أكثر.',
    'condorcet_winner' => 'فائز كوندورسيه',
    'condorcet_loser' => 'خاسر كوندورسيه',
    'none' => 'لا يوجد',
    'no_condorcet_winner_tooltip' => 'لا يوجد مرشح يتغلب على جميع المرشحين الآخرين في المقارنة الثنائية. هذا يعني وجود دورة أو تعادل في تفضيلات الناخبين.',
    'no_condorcet_loser_tooltip' => 'لا يوجد مرشح يخسر أمام جميع المرشحين الآخرين في المقارنة الثنائية. هذا يعني وجود دورة أو تعادل في تفضيلات الناخبين.',
    'election_label' => 'الانتخابات',
    'n_candidates' => ':count مرشح|:count مرشحين',
    'valid_votes' => 'أصوات صالحة',
    'valid_weight' => 'الوزن الصالح:',
    'overview' => 'نظرة عامة',
    'pairwise_matrix_tab' => 'مصفوفة المقارنات',
    'votes_tab' => 'الأصوات',
    'votes_list_heading' => 'جميع الأصوات',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'الطرق لا تتفق على الفائز.',
    'methods_disagree_desc' => 'يمكن لطرق التصويت المختلفة أن تنتج نتائج مختلفة — وهذا هو الدرس الأساسي لنظرية الاختيار الاجتماعي.',
    'method' => 'الطريقة',
    'winner' => 'الفائز',
    'loser' => 'الخاسر',
    'full_ranking' => 'الترتيب الكامل',
    'n_seats' => ':count مقاعد',
    'na' => 'غ/م',
    'na_proportional_winner' => 'الطرق التناسبية تنتخب عدة مقاعد، وليس فائزًا واحدًا.',
    'na_informational_winner' => 'الطرق المعلوماتية تحدد مجموعة من المرشحين، وليس ترتيبًا.',
    'na_proportional_loser' => 'الطرق التناسبية تنتخب عدة مقاعد، وليس خاسرًا واحدًا.',
    'na_informational_loser' => 'الطرق المعلوماتية تحدد مجموعة من المرشحين، وليس ترتيبًا.',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'تناسبي · :seats مقاعد',
    'rank' => 'المرتبة',
    'candidates_header' => 'المرشحون',
    'tied_candidates' => 'مرشحون متعادلون',
    'computation_statistics' => 'إحصاءات الحساب',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'مصفوفة المقارنة الثنائية',
    'pairwise_desc' => 'كل خلية تعرض :wins / :losses للمرشح في الصف مقابل المرشح في العمود.',
    'pairwise_wins' => 'الانتصارات',
    'pairwise_losses' => 'الهزائم',
    'vs' => 'ضد',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'لا يمكن أن يكون اسم المرشح فارغًا.',
    'error_candidate_exists' => 'جميع المرشحين موجودون بالفعل أو الإدخال غير صالح.',
    'error_vote_empty' => 'لا يمكن أن يكون ترتيب التصويت فارغًا.',
    'error_import_empty' => 'الصق محتوى بصيغة .cvotes أولًا.',
    'error_import_failed' => 'فشل الاستيراد: :message',
    'error_file_import_failed' => 'فشل استيراد الملف: :message',
    'error_export_min_candidates' => 'يلزم وجود مرشحَين على الأقل للتصدير.',
    'error_export_build_failed' => 'تعذّر بناء الانتخابات.',
    'error_export_failed' => 'فشل التصدير: :message',
    'warning_vote_error' => 'خطأ في التصويت: :message',
    'warning_pairwise_error' => 'خطأ في المقارنة الثنائية: :message',
    'error_parse_votes_empty' => 'أدخل سطر تصويت واحدًا على الأقل.',
    'error_parse_votes_need_candidates' => 'أضف مرشحَين على الأقل قبل إضافة الأصوات بالجملة.',
    'error_parse_votes_failed' => 'فشل تحليل الأصوات: :message',

    // ──────────────────────────────────────────────
    // Constraint validity (votes-tab.blade.php)
    // ──────────────────────────────────────────────

    'n_invalid_under_constraints' => ':count صوت مرفوض بالقيود|:count أصوات مرفوضة بالقيود',
    'status' => 'الحالة',
    'vote_valid' => 'صالح',
    'vote_invalid' => 'مرفوض',
    'vote_rejected_by_constraint' => 'هذا الصوت مرفوض بواسطة القيد (القيود) النشطة ومستبعد من الحساب.',

    // ──────────────────────────────────────────────
    // Loading states
    // ──────────────────────────────────────────────

    'computing' => 'جارٍ الحساب…',
    'loading' => 'جارٍ تحميل الانتخابات…',
    'processing_time' => ':time',
    'reset_during_loading' => 'إعادة تعيين الانتخابات',

];
