<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\NoMixedEchoPrintFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoMultilineWhitespaceAroundDoubleArrowFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\AttributeNotation\AttributeEmptyParenthesesFixer;
use PhpCsFixer\Fixer\AttributeNotation\OrderedAttributesFixer;
use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\Basic\NoMultipleStatementsPerLineFixer;
use PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer;
use PhpCsFixer\Fixer\Basic\NumericLiteralSeparatorFixer;
use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\Basic\SingleLineEmptyBodyFixer;
use PhpCsFixer\Fixer\Casing\ClassReferenceNameCasingFixer;
use PhpCsFixer\Fixer\Casing\ConstantCaseFixer;
use PhpCsFixer\Fixer\Casing\IntegerLiteralCaseFixer;
use PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer;
use PhpCsFixer\Fixer\Casing\LowercaseStaticReferenceFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeTypeDeclarationCasingFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\CastNotation\NoShortBoolCastFixer;
use PhpCsFixer\Fixer\CastNotation\NoUnsetCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\ClassNotation\FinalInternalClassFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\NoNullPropertyInitializationFixer;
use PhpCsFixer\Fixer\ClassNotation\NoPhp4ConstructorFixer;
use PhpCsFixer\Fixer\ClassNotation\NoUnneededFinalMethodFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedInterfacesFixer;
use PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfStaticAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleTraitInsertPerStatementFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentStyleFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureContinuationPositionFixer;
use PhpCsFixer\Fixer\ControlStructure\ElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\EmptyLoopBodyFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\ControlStructure\NoAlternativeSyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\NoSuperfluousElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededControlParenthesesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\ControlStructure\SimplifiedIfReturnFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchContinueToBreakFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\CombineNestedDirnameFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\ImplodeCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\LambdaNotUsedImportFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUnreachableDefaultArgumentValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUselessSprintfFixer;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\StaticLambdaFixer;
use PhpCsFixer\Fixer\FunctionNotation\UseArrowFunctionsFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\NoUnneededImportAliasFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveIssetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveUnsetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ExplicitIndirectVariableFixer;
use PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\LanguageConstruct\NullableTypeDeclarationFixer;
use PhpCsFixer\Fixer\LanguageConstruct\SingleSpaceAroundConstructFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\CleanNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\Naming\NoHomoglyphNamesFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Operator\LongToShorthandOperatorFixer;
use PhpCsFixer\Fixer\Operator\NewWithParenthesesFixer;
use PhpCsFixer\Fixer\Operator\NoUselessConcatOperatorFixer;
use PhpCsFixer\Fixer\Operator\NoUselessNullsafeOperatorFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\Operator\StandardizeNotEqualsFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\TernaryToElvisOperatorFixer;
use PhpCsFixer\Fixer\Operator\TernaryToNullCoalescingFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAccessFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAliasTagFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoEmptyReturnFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoPackageFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocReturnSelfReferenceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSingleLineVarSpacingFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimConsecutiveBlankLineSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarWithoutNameFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\LinebreakAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertInternalTypeFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitExpectationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitFqcnAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitNamespacedFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitNoExpectationAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitSetUpTearDownVisibilityFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\ReturnNotation\SimplifiedNullReturnFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\SpaceAfterSemicolonFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\NoBinaryStringFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\StringNotation\StringLengthToEmptyFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBetweenImportGroupsFixer;
use PhpCsFixer\Fixer\Whitespace\CompactNullableTypeDeclarationFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Whitespace\LineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesAroundOffsetFixer;
use PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer;
use PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;
use PhpCsFixer\Fixer\Whitespace\SpacesInsideParenthesesFixer;
use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\TypeDeclarationSpacesFixer;
use PhpCsFixer\Fixer\Whitespace\TypesSpacesFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withRootFiles()
    ->withParallel()
    ->withCache(__DIR__ . '/var/cache/ecs')
    ->withRules([
        EncodingFixer::class,
        FullOpeningTagFixer::class,
        BlankLineAfterNamespaceFixer::class,
        BlankLineAfterOpeningTagFixer::class,
        LinebreakAfterOpeningTagFixer::class,
        ClassAttributesSeparationFixer::class,
        ClassReferenceNameCasingFixer::class,
        ConstantCaseFixer::class,
        IntegerLiteralCaseFixer::class,
        LowercaseCastFixer::class,
        LowercaseKeywordsFixer::class,
        LowercaseStaticReferenceFixer::class,
        MagicConstantCasingFixer::class,
        MagicMethodCasingFixer::class,
        NativeFunctionCasingFixer::class,
        NativeTypeDeclarationCasingFixer::class,
        CastSpacesFixer::class,
        ModernizeTypesCastingFixer::class,
        NoShortBoolCastFixer::class,
        NoUnsetCastFixer::class,
        ShortScalarCastFixer::class,
        NoBlankLinesAfterClassOpeningFixer::class,
        NoNullPropertyInitializationFixer::class,
        NoPhp4ConstructorFixer::class,
        NoUnneededFinalMethodFixer::class,
        ProtectedToPrivateFixer::class,
        SelfAccessorFixer::class,
        SelfStaticAccessorFixer::class,
        SingleClassElementPerStatementFixer::class,
        SingleTraitInsertPerStatementFixer::class,
        NoEmptyCommentFixer::class,
        NoTrailingWhitespaceInCommentFixer::class,
        ControlStructureBracesFixer::class,
        ControlStructureContinuationPositionFixer::class,
        ElseifFixer::class,
        NoAlternativeSyntaxFixer::class,
        NoBreakCommentFixer::class,
        NoSuperfluousElseifFixer::class,
        NoUnneededBracesFixer::class,
        NoUnneededControlParenthesesFixer::class,
        NoUselessElseFixer::class,
        SwitchCaseSemicolonToColonFixer::class,
        SwitchCaseSpaceFixer::class,
        SwitchContinueToBreakFixer::class,
        CombineConsecutiveIssetsFixer::class,
        CombineConsecutiveUnsetsFixer::class,
        DeclareEqualNormalizeFixer::class,
        DirConstantFixer::class,
        ExplicitIndirectVariableFixer::class,
        FunctionToConstantFixer::class,
        IsNullFixer::class,
        CombineNestedDirnameFixer::class,
        FunctionDeclarationFixer::class,
        ImplodeCallFixer::class,
        LambdaNotUsedImportFixer::class,
        MethodArgumentSpaceFixer::class,
        NoSpacesAfterFunctionNameFixer::class,
        NoUnreachableDefaultArgumentValueFixer::class,
        NoUselessSprintfFixer::class,
        NullableTypeDeclarationForDefaultNullValueFixer::class,
        ReturnTypeDeclarationFixer::class,
        StaticLambdaFixer::class,
        UseArrowFunctionsFixer::class,
        VoidReturnFixer::class,
        GetClassToClassKeywordFixer::class,
        NoLeadingImportSlashFixer::class,
        NoUnneededImportAliasFixer::class,
        NoUnusedImportsFixer::class,
        SingleImportPerStatementFixer::class,
        SingleLineAfterImportsFixer::class,
        NoMultilineWhitespaceAroundDoubleArrowFixer::class,
        NoWhitespaceBeforeCommaInArrayFixer::class,
        NormalizeIndexBraceFixer::class,
        TrimArraySpacesFixer::class,
        WhitespaceAfterCommaInArrayFixer::class,
        NoAliasFunctionsFixer::class,
        ModernizeStrposFixer::class,
        BinaryOperatorSpacesFixer::class,
        NoHomoglyphNamesFixer::class,
        NoLeadingNamespaceWhitespaceFixer::class,
        CleanNamespaceFixer::class,
        BlankLineBeforeStatementFixer::class,
        DeclareStrictTypesFixer::class,
        IndentationTypeFixer::class,
        LineEndingFixer::class,
        NoBlankLinesAfterPhpdocFixer::class,
        NoClosingTagFixer::class,
        NoEmptyPhpdocFixer::class,
        NoEmptyStatementFixer::class,
        NoSinglelineWhitespaceBeforeSemicolonsFixer::class,
        NoSpacesAroundOffsetFixer::class,
        NoTrailingWhitespaceFixer::class,
        NoWhitespaceInBlankLineFixer::class,
        ObjectOperatorWithoutWhitespaceFixer::class,
        PhpdocIndentFixer::class,
        PhpdocNoAccessFixer::class,
        PhpdocNoAliasTagFixer::class,
        PhpdocNoEmptyReturnFixer::class,
        PhpdocNoPackageFixer::class,
        PhpdocNoUselessInheritdocFixer::class,
        PhpdocOrderFixer::class,
        PhpdocReturnSelfReferenceFixer::class,
        PhpdocScalarFixer::class,
        PhpdocSeparationFixer::class,
        PhpdocSingleLineVarSpacingFixer::class,
        PhpdocTrimFixer::class,
        PhpdocTrimConsecutiveBlankLineSeparationFixer::class,
        PhpdocTypesFixer::class,
        PhpdocVarWithoutNameFixer::class,
        PhpUnitConstructFixer::class,
        PhpUnitDedicateAssertFixer::class,
        PhpUnitDedicateAssertInternalTypeFixer::class,
        PhpUnitExpectationFixer::class,
        PhpUnitFqcnAnnotationFixer::class,
        PhpUnitMethodCasingFixer::class,
        PhpUnitMockFixer::class,
        PhpUnitMockShortWillReturnFixer::class,
        PhpUnitNamespacedFixer::class,
        PhpUnitNoExpectationAnnotationFixer::class,
        PhpUnitSetUpTearDownVisibilityFixer::class,
        PhpUnitTestAnnotationFixer::class,
        SingleBlankLineAtEofFixer::class,
        SingleQuoteFixer::class,
        SpaceAfterSemicolonFixer::class,
        StandardizeNotEqualsFixer::class,
        TernaryOperatorSpacesFixer::class,
        TernaryToNullCoalescingFixer::class,
        TernaryToElvisOperatorFixer::class,
        UnaryOperatorSpacesFixer::class,
        NonPrintableCharacterFixer::class,
        ArrayIndentationFixer::class,
        CompactNullableTypeDeclarationFixer::class,
        MethodChainingIndentationFixer::class,
        TypeDeclarationSpacesFixer::class,
        IncludeFixer::class,
        StrictComparisonFixer::class,
        StrictParamFixer::class,
        OperatorLinebreakFixer::class,
        AssignNullCoalescingToCoalesceEqualFixer::class,
        NoUselessConcatOperatorFixer::class,
        NoUselessNullsafeOperatorFixer::class,
        LongToShorthandOperatorFixer::class,
        SimplifiedIfReturnFixer::class,
        NoBinaryStringFixer::class,
        ExplicitStringVariableFixer::class,
        StringLengthToEmptyFixer::class,
        EmptyLoopBodyFixer::class,
        SingleSpaceAroundConstructFixer::class,
        OctalNotationFixer::class,
        FinalInternalClassFixer::class,
        OrderedInterfacesFixer::class,
        NoMultipleStatementsPerLineFixer::class,
        SingleLineEmptyBodyFixer::class,
        AttributeEmptyParenthesesFixer::class,
        OrderedAttributesFixer::class,
        BlankLineBetweenImportGroupsFixer::class,
        StatementIndentationFixer::class,
        NoUselessReturnFixer::class,
        SimplifiedNullReturnFixer::class,
    ])
    ->withConfiguredRule(TrailingCommaInMultilineFixer::class, [
        'elements' => [
            'arguments',
            'parameters',
            'arrays',
            'match',
        ],
        'after_heredoc' => true,
    ])
    ->withConfiguredRule(NoMixedEchoPrintFixer::class, [
        'use' => 'echo',
    ])
    ->withConfiguredRule(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ])
    ->withConfiguredRule(ClassDefinitionFixer::class, [
        'single_item_single_line' => true,
        'multi_line_extends_each_single_line' => true,
    ])
    ->withConfiguredRule(SingleLineCommentStyleFixer::class, [
        'comment_types' => ['hash'],
    ])
    ->withConfiguredRule(ListSyntaxFixer::class, [
        'syntax' => 'short',
    ])
    ->withConfiguredRule(ConcatSpaceFixer::class, [
        'spacing' => 'one',
    ])
    ->withConfiguredRule(IncrementStyleFixer::class, [
        'style' => 'pre',
    ])
    ->withConfiguredRule(NoExtraBlankLinesFixer::class, [
        'tokens' => [
            'break',
            'case',
            'continue',
            'curly_brace_block',
            'default',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'switch',
            'throw',
            'use',
            'attribute',
        ],
    ])
    ->withConfiguredRule(PhpdocTypesOrderFixer::class, [
        'null_adjustment' => 'always_last',
        'sort_algorithm' => 'none',
    ])
    ->withConfiguredRule(NoSuperfluousPhpdocTagsFixer::class, [
        'allow_mixed' => true,
        'remove_inheritdoc' => true,
    ])
    ->withConfiguredRule(OrderedImportsFixer::class, [
        'sort_algorithm' => 'alpha',
        'imports_order' => ['class', 'function', 'const'],
    ])
    ->withConfiguredRule(GlobalNamespaceImportFixer::class, [
        'import_classes' => true,
        'import_constants' => false,
        'import_functions' => false,
    ])
    ->withConfiguredRule(FullyQualifiedStrictTypesFixer::class, [
        'import_symbols' => true,
    ])
    ->withConfiguredRule(NativeConstantInvocationFixer::class, [
        'scope' => 'namespaced',
        'strict' => true,
        'fix_built_in' => true,
    ])
    ->withConfiguredRule(NativeFunctionInvocationFixer::class, [
        'scope' => 'namespaced',
        'strict' => true,
        'include' => ['@compiler_optimized'],
    ])
    ->withConfiguredRule(YodaStyleFixer::class, [
        'equal' => false,
        'identical' => false,
        'less_and_greater' => false,
    ])
    ->withConfiguredRule(NewWithParenthesesFixer::class, [
        'anonymous_class' => true,
        'named_class' => true,
    ])
    ->withConfiguredRule(NullableTypeDeclarationFixer::class, [
        'syntax' => 'question_mark',
    ])
    ->withConfiguredRule(TypesSpacesFixer::class, [
        'space' => 'none',
    ])
    ->withConfiguredRule(SpacesInsideParenthesesFixer::class, [
        'space' => 'none',
    ])
    ->withConfiguredRule(OrderedClassElementsFixer::class, [
        'order' => [
            'use_trait',
            'case',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property_public_static',
            'property_protected_static',
            'property_private_static',
            'property_public',
            'property_protected',
            'property_private',
            'construct',
            'destruct',
            'magic',
            'phpunit',
            'method_public_static',
            'method_protected_static',
            'method_private_static',
            'method_public',
            'method_protected',
            'method_private',
        ],
        'sort_algorithm' => 'none',
    ])
    ->withConfiguredRule(NumericLiteralSeparatorFixer::class, [
        'strategy' => 'use_separator',
        'override_existing' => true,
    ])
    ->withConfiguredRule(PhpUnitStrictFixer::class, [
        'assertions' => [
            'assertAttributeEquals',
            'assertAttributeNotEquals',
            'assertEquals',
            'assertNotEquals',
        ],
    ])
    ->withConfiguredRule(MultilineWhitespaceBeforeSemicolonsFixer::class, [
        'strategy' => 'no_multi_line',
    ])
    ->withSkip([
        '*/var/*',
        '*/vendor/*',
        '*/node_modules/*',
        '*/migrations/*',
    ]);
