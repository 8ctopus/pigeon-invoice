<?php

$finder = PhpCsFixer\Finder::create()
    ->in('.');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PhpCsFixer' => true,
        'blank_line_before_statement' => [
            'statements' => ['case', 'default'],
        ],
        'concat_space' => ['spacing' => 'one'],
        'echo_tag_syntax' => ['format' => 'short'],
        'multiline_whitespace_before_semicolons' => false,
        'no_superfluous_phpdoc_tags' => false,
        'no_useless_else' => false,
        'phpdoc_no_empty_return' => false,
        'phpdoc_summary' => false,
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'php_unit_method_casing' => false,
        'return_type_declaration' => ['space_before' => 'one'],
        'single_line_comment_spacing' => false,
        'yoda_style' => false,
    ])
    ->setFinder($finder);
