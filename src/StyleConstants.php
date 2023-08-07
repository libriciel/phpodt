<?php

namespace PhpOdt;

/**
 * A Class containing constants used in the library.
 */
class StyleConstants
{
    public const NONE = 1;
    public const NORMAL = 7;
    public const AUTO = 22;

    /** Lower case text transform */
    public const LOWER_CASE = 2;
    /** Upper case text transform */
    public const UPPER_CASE = 3;
    /** Capitalize text transform */
    public const CAPITALIZE = 4;

    /** Single line */
    public const SINGLE = 5;
    /** Double line */
    public const DOUBLE = 6;

    /** Below the baseline */
    public const SUB = 9;
    /** Above the baseline */
    public const SUPER = 10;

    /** Italic */
    public const ITALIC = 12;
    /** Oblique */
    public const OBLIQUE = 13;

    /** Italic */
    public const EMBOSSED = 14;
    /** Oblique */
    public const ENGRAVED = 15;

    /** Solid Underline */
    public const SOLID = 16;
    /** Dotted Underline */
    public const DOTTED = 17;
    /** Dash Underline */
    public const DASH = 18;
    /** Long dash Underline */
    public const LONG_DASH = 19;
    /** Dot dot dash Underline */
    public const DOT_DOT_DASH = 20;
    /** Wave Underline */
    public const WAVE = 21;

    /** Bold line */
    public const BOLD = 24;
    /** Thin Underline */
    public const THIN = 25;
    /** Medium Underline */
    public const MEDIUM = 27;
    /** Thick Underline */
    public const THICK = 28;

    /** Continuous underline */
    public const CONTINUOUS = 29;
    /** Skip white spaces when underlining */
    public const SKIP_WHITE_SPACE = 30;

    /** Letters */
    public const LETTERS = 31;
    /** Letters */
    public const LINES = 32;

    /** Specifies that the content is to be aligned on the start-edge in the inline-progression-direction. */
    public const START = 33;
    /** Specifies that the content is to be aligned on the end-edge in the inline-progression-direction. */
    public const END = 34;
    /** (Interpreted as START if for progression-direction.), (Align table left) */
    public const LEFT = 35;
    /** (Interpreted as END if for progression-direction.), (Align table right) */
    public const RIGHT = 36;
    /** (Specifies that the content is to be centered in the inline-progression-direction.), (Center the table) */
    public const CENTER = 37;
    /** Specifies that the contents is to be expanded to fill the available width in the inline-progression-direction.*/
    public const JUSTIFY = 38;

    /** The lines of a paragraph should be kept together on the same page or column */
    public const ALWAYS = 39;

    /** Page break */
    public const PAGE = 40;
    /** Column break */
    public const COLUMN = 41;

    /** Transparent */
    public const TRANSPARENT = 42;

    /** No repetition */
    public const NO_REPEAT = 43;
    /** Repeat background image */
    public const REPEAT = 44;
    /** Stretch image */
    public const STRETCH = 45;

    /** Top */
    public const TOP = 46;
    /** Bottom */
    public const BOTTOM = 47;
    /** Middle */
    public const MIDDLE = 48;
    /** Baseline */
    public const BASELINE = 49;

    /** Inline components and text within a line are written left-to-right. Lines and blocks are placed top-to-bottom. */
    public const LR_TB = 50;
    /** Inline components and text within a line are written right-to-left. Lines and blocks are placed top-to-bottom. */
    public const RL_TB = 51;
    /** Inline components and text within a line are written top-to-bottom. Lines and blocks are placed right-to-left. */
    public const TB_RL = 52;
    /** Inline components and text within a line are stacked top-to-bottom. Lines and blocks are stacked left-to-right. */
    public const TB_LR = 53;
    /** Shorthand for lr-tb. */
    public const LR = 54;
    /** Shorthand for rl-tb. */
    public const RL = 55;
    /** Shorthand for tb-rl. */
    public const TB = 56;

    /** Portrait */
    public const PORTRAIT = 57;
    /** Landscape */
    public const LANDSCAPE = 58;

    /** Current page number */
    public const PAGE_NUMBER = 59;
    /** Current date */
    public const CURRENT_DATE = 60;

    /** In the case of table: The table fills all the space between the left and right margins,  */
    public const MARGINS = 61;

    public const COLLAPSING = 62;
    public const SEPARATING = 63;

    public const FIX = 64;
    public const VALUE_TYPE = 65;

    public const LTR = 66;
    public const TTB = 67;

    public const WRAP = 68;
    public const NO_WRAP = 69;

    public const BULLET = '&#x2022;';
    public const BLACK_CIRCLE = '&#x25CF;';
    public const CHECK_MARK = '&#x2714;';
    public const BALLOT_X = '&#x2717;';
    public const RIGHT_ARROW = '&#x2794;';
    public const RIGHT_ARROWHEAD = '&#x27A2;';

    public const RUBY_ABOVE = 70;
    public const RUBY_BELOW = 71;

    public const DISTRIBUTE_LETTER = 72;
    public const DISTRIBUTE_SPACE = 73;

    public const FOOTNOTE = 74;
    public const ENDNOTE = 75;
}
