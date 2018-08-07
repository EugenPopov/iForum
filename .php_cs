<?php
$header = <<<HEADER

HEADER;
$finder = \PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('docs')
;
return \PhpCsFixer\Config::create()
    ->setCacheFile(__DIR__ . '/php_cs.cache')
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => [
            'syntax' => 'short',
        ],
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => [
                'for',
                'foreach',
                'if',
                'return',
                'switch',
                'while',
            ],
        ],
        'cast_spaces' => [
            'space' => 'single',
        ],
        'compact_nullable_typehint' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'function_typehint_space' => true,
        'header_comment' => [
            'header' => $header,
            'commentType' => 'comment',
            'separate' => 'both',
        ],
        // PHP 7.x only
        'list_syntax' => [
            'syntax' => 'short',
        ],
        'lowercase_cast' => true,
        'lowercase_static_reference' => true,
        'multiline_comment_opening_closing' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_null_property_initialization' => true,
        'no_short_bool_cast' => true,
        'no_superfluous_elseif' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unneeded_final_method' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_whitespace_before_comma_in_array' => true,
        'object_operator_without_whitespace' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_no_package' => true,
        'phpdoc_no_useless_inheritdoc' => true,
        'phpdoc_order' => true,
        'phpdoc_return_self_reference' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_to_comment' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => true,
        'phpdoc_var_without_name' => true,
        // PHP 7.x only
        'return_type_declaration' => true,
        'short_scalar_cast' => true,
        'single_quote' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        // PHP 7.x only
        'ternary_to_null_coalescing' => true,
        'trailing_comma_in_multiline_array' => true,
        'yoda_style' => true,
        'new_with_braces' => true,
    ])
    ->setFinder($finder)
;
