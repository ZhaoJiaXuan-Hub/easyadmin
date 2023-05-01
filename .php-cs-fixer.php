<?php

$header = <<<'EOF'
This file is part of Hyperf.

@link     https://www.hyperf.io
@document https://hyperf.wiki
@contact  group@hyperf.io
@license  https://github.com/hyperf/hyperf/blob/master/LICENSE
EOF;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setRules([
        '@PSR2' => false,
        '@Symfony' => false,
        '@DoctrineAnnotation' => false,
        '@PhpCsFixer' => false,
        'header_comment' => [
            'comment_type' => 'PHPDoc',
            'header' => $header,
            'separate' => 'none',
            'location' => 'after_declare_strict',
        ],
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'list_syntax' => [
            'syntax' => 'short'
        ],
        'concat_space' => [
            'spacing' => 'one'
        ],
        'blank_line_before_statement' => [
            'statements' => [
                'declare',
            ],
        ],
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                'author'
            ],
        ],
        'ordered_imports' => [
            'imports_order' => [
                'class', 'function', 'const',
            ],
            'sort_algorithm' => 'alpha',
        ],
        'single_line_comment_style' => [
            'comment_types' => [
            ],
        ],
        'yoda_style' => [
            'always_move_variable' => false,
            'equal' => false,
            'identical' => false,
        ],
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
        'constant_case' => [
            'case' => 'lower',
        ],
        'class_attributes_separation' => false,
        'combine_consecutive_unsets' => false,
        'declare_strict_types' => false,
        'linebreak_after_opening_tag' => false,
        'lowercase_static_reference' => false,
        'no_useless_else' => false,
        'no_unused_imports' => false,
        'not_operator_with_successor_space' => false,
        'not_operator_with_space' => false,
        'ordered_class_elements' => false,
        'php_unit_strict' => false,
        'phpdoc_separation' => false,
        'single_quote' => false,
        'standardize_not_equals' => false,
        'multiline_comment_opening_closing' => false,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('public')
            ->exclude('runtime')
            ->exclude('vendor')
            ->in(__DIR__)
    )
    ->setUsingCache(false);
