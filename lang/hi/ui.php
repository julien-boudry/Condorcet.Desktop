<?php

/**
 * Hindi UI translations for Condorcet Desktop.
 *
 * Organised by view/section. Keys are prefixed by area:
 * layout, election, candidates, votes, config, methods,
 * import_export, results, errors.
 */

return [

    // ──────────────────────────────────────────────
    // Layout (app.blade.php)
    // ──────────────────────────────────────────────

    'app_name' => 'Condorcet डेस्कटॉप',
    'switch_to_light' => 'लाइट मोड में बदलें',
    'switch_to_dark' => 'डार्क मोड में बदलें',

    // ──────────────────────────────────────────────
    // Election manager (election-manager.blade.php)
    // ──────────────────────────────────────────────

    'election_in_progress' => 'चुनाव चल रहा है',
    'reset' => 'रीसेट',
    'confirm_reset' => 'क्या आप वाकई पूरे चुनाव को रीसेट करना चाहते हैं?',
    'warnings' => 'चेतावनियाँ',
    'see_results' => 'परिणाम देखें',

    // ──────────────────────────────────────────────
    // Candidates (candidate-panel.blade.php)
    // ──────────────────────────────────────────────

    'candidates' => 'उम्मीदवार',
    'add' => 'जोड़ें',
    'candidate_placeholder' => 'Alice या Alice ; Bob ; Charlie',
    'candidate_hint' => 'एक साथ कई जोड़ने के लिए अर्धविराम का उपयोग करें',
    'no_candidates' => 'अभी तक कोई उम्मीदवार नहीं।',
    'remove_candidate' => ':candidate को हटाएँ',

    // ──────────────────────────────────────────────
    // Votes (vote-panel.blade.php)
    // ──────────────────────────────────────────────

    'votes' => 'वोट',
    'weight' => 'भार',
    'quantity' => 'मात्रा',
    'add_vote' => 'वोट जोड़ें',
    'vote_placeholder' => 'Alice > Bob > Charlie  या  Alice = Bob > Charlie',
    'weight_auto' => 'स्वचालित',
    'vote_entries' => ':count वोट प्रविष्टि|:count वोट प्रविष्टियाँ',
    'total_weight' => 'कुल भार:',
    'no_votes' => 'अभी तक कोई वोट नहीं।',
    'remove_vote' => 'वोट हटाएँ',

    // ──────────────────────────────────────────────
    // Configuration (config-panel.blade.php)
    // ──────────────────────────────────────────────

    'configuration' => 'कॉन्फ़िगरेशन',
    'implicit_ranking' => 'निहित रैंकिंग',
    'implicit_ranking_desc' => 'सक्षम होने पर, बिना रैंक वाले उम्मीदवार निहित रूप से अंतिम स्थान पर बराबरी पर होते हैं। अक्षम होने पर, उन्हें कोई अंक नहीं मिलते।',
    'allow_vote_weight' => 'वोट भार की अनुमति दें',
    'allow_vote_weight_desc' => 'सक्षम होने पर, प्रत्येक वोट का अलग-अलग भार हो सकता है जो उसके प्रभाव को बढ़ाता है।',
    'no_tie_constraint' => 'बराबरी-निषेध प्रतिबंध',
    'no_tie_constraint_desc' => 'बराबरी वाले वोटों को अस्वीकार करें। कुछ आनुपातिक विधियों (STV) के लिए अनुशंसित।',
    'number_of_seats' => 'सीटों की संख्या',
    'seats_desc' => 'आनुपातिक विधियों के लिए आवश्यक (STV, D\'Hondt, Sainte-Laguë, आदि)।',

    // ──────────────────────────────────────────────
    // Methods (method-selector.blade.php)
    // ──────────────────────────────────────────────

    'voting_methods' => 'मतदान विधियाँ',
    'method_options' => 'विधि विकल्प',
    'group_single_winner' => 'एकल विजेता',
    'group_proportional' => 'आनुपातिक',
    'group_informational' => 'सूचनात्मक',
    'borda_starting' => 'Borda प्रारंभ बिंदु',
    'borda_standard' => '1 (मानक)',
    'kemeny_max' => 'Kemeny–Young अधिकतम उम्मीदवार',
    'kemeny_placeholder' => '10 (बिना सीमा के लिए खाली छोड़ें)',
    'kemeny_slow_warning' => '10 उम्मीदवारों से अधिक होने पर गणना बहुत धीमी हो जाती है।',
    'stv_quota' => 'STV कोटा',
    'cpo_stv_quota' => 'CPO-STV कोटा',
    'sainte_lague_divisor' => 'Sainte-Laguë पहला भाजक',
    'sainte_lague_hint' => '1 = मानक · 1.4 = नॉर्वेजियन संस्करण',
    'largest_remainder_quota' => 'सबसे बड़ा शेष कोटा',

    // ──────────────────────────────────────────────
    // Import / Export (import-export.blade.php)
    // ──────────────────────────────────────────────

    'import_export' => 'आयात / निर्यात',
    'import_cvotes' => '.cvotes प्रारूप से आयात करें',
    'export_cvotes' => '.cvotes प्रारूप में निर्यात करें',
    'import' => 'आयात',
    'import_file' => 'फ़ाइल आयात करें',
    'uploading' => 'अपलोड हो रहा है…',
    'replace_warning' => 'यह सभी वर्तमान डेटा को बदल देगा',
    'generate_export' => 'निर्यात उत्पन्न करें',
    'copy' => 'कॉपी करें',
    'copied' => 'कॉपी हो गया!',
    'download_cvotes' => '.cvotes डाउनलोड करें',

    // ──────────────────────────────────────────────
    // Results — display (results-display.blade.php)
    // ──────────────────────────────────────────────

    'no_results' => 'प्रदर्शित करने के लिए कोई परिणाम नहीं',
    'no_results_hint' => 'परिणाम की गणना के लिए कम से कम <strong>2 उम्मीदवार</strong> और <strong>1 वोट</strong> जोड़ें।',
    'no_results_methods_hint' => 'फिर एक या अधिक <strong>मतदान विधियाँ</strong> चुनें।',
    'condorcet_winner' => 'Condorcet विजेता',
    'condorcet_loser' => 'Condorcet पराजित',
    'none' => 'कोई नहीं',
    'no_condorcet_winner_tooltip' => 'कोई भी उम्मीदवार जोड़ीवार तुलना में हर दूसरे उम्मीदवार को नहीं हराता। इसका मतलब है कि मतदाता वरीयताओं में एक चक्र या बराबरी है।',
    'no_condorcet_loser_tooltip' => 'कोई भी उम्मीदवार जोड़ीवार तुलना में हर दूसरे उम्मीदवार से नहीं हारता। इसका मतलब है कि मतदाता वरीयताओं में एक चक्र या बराबरी है।',
    'election_label' => 'चुनाव',
    'n_candidates' => ':count उम्मीदवार',
    'valid_votes' => 'वैध वोट',
    'valid_weight' => 'वैध भार:',
    'overview' => 'अवलोकन',
    'pairwise_matrix_tab' => 'जोड़ीवार तुलना मैट्रिक्स',

    // ──────────────────────────────────────────────
    // Results — overview (results-overview.blade.php)
    // ──────────────────────────────────────────────

    'methods_disagree' => 'विधियाँ विजेता पर सहमत नहीं हैं।',
    'methods_disagree_desc' => 'अलग-अलग मतदान विधियाँ अलग-अलग परिणाम दे सकती हैं — यह सामाजिक चयन सिद्धांत की मूल अंतर्दृष्टि है।',
    'method' => 'विधि',
    'winner' => 'विजेता',
    'loser' => 'पराजित',
    'full_ranking' => 'पूर्ण रैंकिंग',
    'n_seats' => ':count सीटें',
    'na' => 'लागू नहीं',
    'na_proportional_winner' => 'आनुपातिक विधियाँ कई सीटें चुनती हैं, एक विजेता नहीं।',
    'na_informational_winner' => 'सूचनात्मक विधियाँ उम्मीदवारों का एक समूह पहचानती हैं, रैंकिंग नहीं।',
    'na_proportional_loser' => 'आनुपातिक विधियाँ कई सीटें चुनती हैं, एक पराजित नहीं।',
    'na_informational_loser' => 'सूचनात्मक विधियाँ उम्मीदवारों का एक समूह पहचानती हैं, रैंकिंग नहीं।',

    // ──────────────────────────────────────────────
    // Results — method detail (results-method-detail.blade.php)
    // ──────────────────────────────────────────────

    'proportional_seats' => 'आनुपातिक · :seats सीटें',
    'rank' => 'रैंक',
    'candidates_header' => 'उम्मीदवार',
    'tied_candidates' => 'बराबरी वाले उम्मीदवार',
    'computation_statistics' => 'गणना आँकड़े',

    // ──────────────────────────────────────────────
    // Pairwise matrix (pairwise-matrix.blade.php)
    // ──────────────────────────────────────────────

    'pairwise_heading' => 'जोड़ीवार तुलना मैट्रिक्स',
    'pairwise_desc' => 'प्रत्येक सेल पंक्ति उम्मीदवार की स्तंभ उम्मीदवार के विरुद्ध <span class="font-semibold text-green-600 dark:text-green-400">जीत</span> / <span class="font-semibold text-red-600 dark:text-red-400">हार</span> दिखाता है।',
    'vs' => 'बनाम',

    // ──────────────────────────────────────────────
    // Error & warning messages (ElectionManager.php)
    // ──────────────────────────────────────────────

    'error_candidate_empty' => 'उम्मीदवार का नाम खाली नहीं हो सकता।',
    'error_candidate_exists' => 'सभी उम्मीदवार पहले से मौजूद हैं या इनपुट अमान्य है।',
    'error_vote_empty' => 'वोट रैंकिंग खाली नहीं हो सकती।',
    'error_import_empty' => 'पहले कुछ .cvotes सामग्री पेस्ट करें।',
    'error_import_failed' => 'आयात विफल: :message',
    'error_file_import_failed' => 'फ़ाइल आयात विफल: :message',
    'error_export_min_candidates' => 'निर्यात के लिए कम से कम 2 उम्मीदवार चाहिए।',
    'error_export_build_failed' => 'चुनाव बनाने में असमर्थ।',
    'error_export_failed' => 'निर्यात विफल: :message',
    'warning_vote_error' => 'वोट त्रुटि: :message',
    'warning_pairwise_error' => 'जोड़ीवार तुलना त्रुटि: :message',

];
