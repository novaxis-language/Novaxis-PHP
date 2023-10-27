<?php
namespace Novaxis\Core\Syntax\Handler;

use Novaxis\Core\Syntax\Token\CommentTokens;

class CommentHandler {
	use CommentTokens;

	/**
	 * The regex pattern used for comment detection.
	 * 
	 * @var string
	 */
	private $pattern;

	/**
	 * CommentHandler constructor.
	 * 
	 * Initializes the CommentHandler with the proper regex pattern for comment detection.
	 */
	public function __construct() {
		$escapedCharacters = array_map(function($char) {
			return ($char === "//") ? preg_quote($char, '/') : $char;
		}, self::COMMENT_DECLARE);
		$regex = implode('|', $escapedCharacters);

		$this -> pattern = "(?<!\\\\)\s*(?:$regex)";
	}

	/**
	 * Checks if the given line contains a comment.
	 *
	 * @param string $line The input line to check.
	 * @return bool Returns true if the line contains a comment, otherwise false.
	 */
	public function is(string $line): bool {
		return preg_match('/' . $this -> pattern . '/', $line);
	}

	/**
	 * Splits the given line and returns the part before the comment if it exists.
	 *
	 * @param string $line The input line to split.
	 * @return string The part of the line before the comment or the whole line if no comment is found.
	 */
	public function split(string $line) {
		$pattern = '/^(.*?)' . $this -> pattern . '/';

		preg_match($pattern, $line, $matches);

		return isset($matches[1]) ? $matches[1] : $line;
	}
}