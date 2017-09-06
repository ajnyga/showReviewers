<?php

/**
 * @defgroup plugins_generic_showReviewers showReviewers Plugin
 */
 
/**
 * @file plugins/generic/showReviewers/index.php
 *
 * Copyright (c) 2014-2017 Simon Fraser University
 * Copyright (c) 2003-2017 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_showReviewers
 * @brief Wrapper for showReviewers plugin.
 *
 */

require_once('ShowReviewersPlugin.inc.php');

return new ShowReviewersPlugin();

?>
