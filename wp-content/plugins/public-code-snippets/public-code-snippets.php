<?php
/*
Plugin Name: Public Code Snippets Search
Description: Search and copy public WordPress code snippets (no API key required).
Version: 1.1
Author: Your Name
*/

if ( ! defined( 'ABSPATH' ) ) exit;

add_action('admin_menu', function() {
    add_menu_page(
        'Public Code Snippets',
        'Code Snippets',
        'manage_options',
        'public-code-snippets',
        'pcs_admin_page',
        'dashicons-search',
        3
    );
});

function pcs_admin_page() {
    ?>
    <div class="wrap">
        <h1>Public Code Snippets Search</h1>
        <button type="button" id="pcs-dark-toggle" class="button" style="float:right;">Toggle Dark Mode</button>
        <form id="pcs-form" onsubmit="return false;">
            <input type="text" id="pcs-query" style="width:40%" placeholder="Search for WordPress code (e.g. WP_Query loop)">
            <select id="pcs-lang-filter" style="width:15%">
                <option value="">All Languages</option>
                <option value="PHP">PHP</option>
                <option value="JS">JS</option>
                <option value="CSS">CSS</option>
            </select>
            <button type="submit" class="button button-primary">Search</button>
            <button type="button" id="pcs-copy-all" class="button">Copy All</button>
            <button type="button" id="pcs-export" class="button">Export Snippets</button>
        </form>
        <div id="pcs-results" style="margin-top:2em;"></div>
        <h2>Add New Snippet</h2>
        <form id="pcs-add-form">
            <input type="text" id="pcs-add-title" placeholder="Snippet Title" style="width:20%" required>
            <select id="pcs-add-lang" required>
                <option value="PHP">PHP</option>
                <option value="JS">JS</option>
                <option value="CSS">CSS</option>
            </select>
            <textarea id="pcs-add-code" placeholder="Your code here..." style="width:40%;min-height:60px;" required></textarea>
            <button type="submit" class="button">Add Snippet</button>
        </form>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('pcs-form');
            if (form) {
                form.onsubmit = function(e) {
                    e.preventDefault();
                    var q = document.getElementById('pcs-query').value;
                    var lang = document.getElementById('pcs-lang-filter').value;
                    var results = document.getElementById('pcs-results');
                    results.innerHTML = 'Searching...';
                    var data = 'action=pcs_search&q=' + encodeURIComponent(q) + '&lang=' + encodeURIComponent(lang);
                    fetch(ajaxurl, {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: data
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.data.html) {
                            results.innerHTML = data.data.html;
                            // Add copy button event listeners after results are rendered
                            document.querySelectorAll('.pcs-copy-btn').forEach(function(btn) {
                                btn.onclick = function() {
                                    var targetId = btn.getAttribute('data-target');
                                    var textarea = document.getElementById(targetId);
                                    textarea.select();
                                    document.execCommand('copy');
                                    btn.textContent = 'Copied!';
                                    setTimeout(function() { btn.textContent = 'Copy'; }, 1200);
                                };
                            });
                        } else {
                            results.innerHTML = 'No results found.';
                        }
                    });
                };
            }
            // Also add copy listeners for initial page load (if any snippets are present)
            document.querySelectorAll('.pcs-copy-btn').forEach(function(btn) {
                btn.onclick = function() {
                    var targetId = btn.getAttribute('data-target');
                    var textarea = document.getElementById(targetId);
                    textarea.select();
                    document.execCommand('copy');
                    btn.textContent = 'Copied!';
                    setTimeout(function() { btn.textContent = 'Copy'; }, 1200);
                };
            });
            // Copy All button
            var copyAllBtn = document.getElementById('pcs-copy-all');
            if (copyAllBtn) {
                copyAllBtn.onclick = function() {
                    var allTextareas = document.querySelectorAll('#pcs-results textarea');
                    var allCode = Array.from(allTextareas).map(t => t.value).join('\n\n');
                    var temp = document.createElement('textarea');
                    temp.value = allCode;
                    document.body.appendChild(temp);
                    temp.select();
                    document.execCommand('copy');
                    document.body.removeChild(temp);
                    this.textContent = 'All Copied!';
                    setTimeout(() => { this.textContent = 'Copy All'; }, 1200);
                };
            }
            // Export Snippets button
            var exportBtn = document.getElementById('pcs-export');
            if (exportBtn) {
                exportBtn.onclick = function() {
                    fetch(ajaxurl, {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: 'action=pcs_export_snippets'
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.data.snippets) {
                            var blob = new Blob([JSON.stringify(data.data.snippets, null, 2)], {type: 'application/json'});
                            var url = URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = 'snippets.json';
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);
                            URL.revokeObjectURL(url);
                        }
                    });
                };
            }
        });
        </script>
    </div>
    <?php
}

/**
 * Returns an array of local WordPress code snippets for searching and copying.
 * Each snippet is an array: [title, language, code].
 *
 * @return array List of code snippets.
 */
function pcs_get_local_snippets() {
    return [
        [
            'WP_Query loop',
            'PHP',
            "<?php\n$args = array('post_type' => 'post', 'posts_per_page' => 5);\n$query = new WP_Query($args);\nif ( $query->have_posts() ) :\n    while ( $query->have_posts() ) : $query->the_post();\n        the_title('<h2>', '</h2>');\n        the_excerpt();\n    endwhile;\n    wp_reset_postdata();\nelse :\n    echo 'No posts found.';\nendif;\n?>"
        ],
        [
            'Register custom post type',
            'PHP',
            "add_action('init', function() {\n    register_post_type('book', array('label' => 'Books', 'public' => true));\n});"
        ],
        [
            'Register custom taxonomy',
            'PHP',
            "add_action('init', function() {\n    register_taxonomy('genre', 'book', array('label' => 'Genres', 'hierarchical' => true));\n});"
        ],
        [
            'Add custom user role',
            'PHP',
            "add_role('custom_role', 'Custom Role', array('read' => true));"
        ],
        [
            'Remove WordPress version',
            'PHP',
            "remove_action('wp_head', 'wp_generator');"
        ],
        [
            'Disable Gutenberg editor',
            'PHP',
            "add_filter('use_block_editor_for_post', '__return_false');"
        ],
        [
            'Add custom dashboard widget',
            'PHP',
            "add_action('wp_dashboard_setup', function() {\n    wp_add_dashboard_widget('custom_widget', 'Custom Widget', function() {\n        echo 'Hello, this is a custom dashboard widget!';\n    });\n});"
        ],
        [
            'Redirect after login',
            'PHP',
            "add_filter('login_redirect', function($redirect_to, $request, $user) {\n    return home_url('/welcome/');\n}, 10, 3);"
        ],
        [
            'Limit post revisions',
            'PHP',
            "define('WP_POST_REVISIONS', 5);"
        ],
        [
            'Simple JS Alert',
            'JS',
            "alert('Hello from a JS snippet!');"
        ],
        [
            'Add Class to Body',
            'JS',
            "document.body.classList.add('my-custom-class');"
        ],
        [
            'Console Log Example',
            'JS',
            "console.log('This is a JavaScript snippet!');"
        ],
        // ...add more as needed...
    ];
}

add_action('wp_ajax_pcs_search', function() {
    $q = strtolower(trim(sanitize_text_field($_POST['q'] ?? '')));
    $lang = sanitize_text_field($_POST['lang'] ?? '');
    $snippets = pcs_get_local_snippets();
    $html = '';
    $i = 0;
    // If query is empty or only whitespace, show all snippets
    if ($q === '' || strlen($q) < 2) {
        foreach ($snippets as $snippet) {
            $id = 'pcs-snippet-' . $i;
            $html .= '<div class="pcs-snippet-box" style="margin-bottom:2em;padding:1em;border:1px solid #ddd;background:#fafbfc;">';
            $html .= '<strong>' . esc_html($snippet[0]) . ' (' . esc_html($snippet[1]) . ')</strong>';
            $html .= '<textarea id="' . $id . '" style="width:100%;min-height:100px;">' . esc_textarea($snippet[2]) . '</textarea>';
            $html .= '<button class="button pcs-copy-btn" data-target="' . $id . '" style="margin-top:5px;">Copy</button> ';
            $html .= '<button class="button pcs-edit-btn" data-target="' . $id . '" style="margin-top:5px;">Edit</button>';
            $html .= '</div>';
            $i++;
        }
        wp_send_json_success(['html' => $html]);
    }
    // Otherwise, filter by query
    foreach ($snippets as $snippet) {
        if (strpos(strtolower($snippet[0]), $q) !== false || strpos(strtolower($snippet[2]), $q) !== false) {
            if ($lang && strtolower($snippet[1]) !== strtolower($lang)) {
                continue; // Skip this snippet if language filter is active and doesn't match
            }
            $id = 'pcs-snippet-' . $i;
            $html .= '<div class="pcs-snippet-box" style="margin-bottom:2em;padding:1em;border:1px solid #ddd;background:#fafbfc;">';
            $html .= '<strong>' . esc_html($snippet[0]) . ' (' . esc_html($snippet[1]) . ')</strong>';
            $html .= '<textarea id="' . $id . '" style="width:100%;min-height:100px;">' . esc_textarea($snippet[2]) . '</textarea>';
            $html .= '<button class="button pcs-copy-btn" data-target="' . $id . '" style="margin-top:5px;">Copy</button> ';
            $html .= '<button class="button pcs-edit-btn" data-target="' . $id . '" style="margin-top:5px;">Edit</button>';
            $html .= '</div>';
            $i++;
        }
    }
    if ($html) {
        wp_send_json_success(['html' => $html]);
    }
    wp_send_json_success(['html' => 'No results found.']);
});
// Export snippets AJAX handler
add_action('wp_ajax_pcs_export_snippets', function() {
    $snippets = pcs_get_local_snippets();
    wp_send_json_success(['snippets' => $snippets]);
});

add_action('admin_enqueue_scripts', function($hook) {
    if ($hook === 'toplevel_page_public-code-snippets') {
        wp_enqueue_style('pcs-style', plugins_url('public-code-snippets.css', __FILE__));
        wp_enqueue_script('pcs-script', plugins_url('public-code-snippets.js', __FILE__), ['jquery'], false, true);
        // Localize ajaxurl for JS
        wp_localize_script('pcs-script', 'ajaxurl', admin_url('admin-ajax.php'));
    }
});
