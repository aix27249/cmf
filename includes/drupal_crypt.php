<?php
define('DRUPAL_HASH_COUNT', 15);

function _password_generate_salt($count_log2) {
	$output = '$S$';
	// Ensure that $count_log2 is within set bounds.
	$count_log2 = _password_enforce_log2_boundaries($count_log2);
	// We encode the final log2 iteration count in base 64.
	$itoa64 = _password_itoa64();
	$output .= $itoa64[$count_log2];
	// 6 bytes is the standard salt for a portable phpass hash.
	$output .= _password_base64_encode(drupal_random_bytes(6), 6);
	return $output;
}

function _password_crypt($algo, $password, $setting) {
	// The first 12 characters of an existing hash are its setting string.
	$setting = substr($setting, 0, 12);

	if ($setting[0] != '$' || $setting[2] != '$') {
		return FALSE;
	}
	$count_log2 = _password_get_count_log2($setting);
	// Hashes may be imported from elsewhere, so we allow != DRUPAL_HASH_COUNT
	if ($count_log2 < DRUPAL_MIN_HASH_COUNT || $count_log2 > DRUPAL_MAX_HASH_COUNT) {
		return FALSE;
	}
	$salt = substr($setting, 4, 8);
	// Hashes must have an 8 character salt.
	if (strlen($salt) != 8) {
		return FALSE;
	}

	// Convert the base 2 logarithm into an integer.
	$count = 1 << $count_log2;

	// We rely on the hash() function being available in PHP 5.2+.
	$hash = hash($algo, $salt . $password, TRUE);
	do {
		$hash = hash($algo, $hash . $password, TRUE);
	} while (--$count);

	$len = strlen($hash);
	$output =  $setting . _password_base64_encode($hash, $len);
	// _password_base64_encode() of a 16 byte MD5 will always be 22 characters.
	// _password_base64_encode() of a 64 byte sha512 will always be 86 characters.
	$expected = 12 + ceil((8 * $len) / 6);
	return (strlen($output) == $expected) ? substr($output, 0, DRUPAL_HASH_LENGTH) : FALSE;
}

function user_hash_password($password, $count_log2 = 0) {
	if (empty($count_log2)) {
		// Use the standard iteration count.
		$count_log2 = variable_get('password_count_log2', DRUPAL_HASH_COUNT);
	}
	return _password_crypt('sha512', $password, _password_generate_salt($count_log2));
}
