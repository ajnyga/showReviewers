<?php

/**
 * @file plugins/generic/showReviewers/ShowReviewersPlugin.inc.php
 *
 * Copyright (c) 2014-2017 Simon Fraser University
 * Copyright (c) 2003-2017 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class showReviewers
 * @ingroup plugins_generic_showReviewers
 *
 * @brief showReviewers plugin class
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class ShowReviewersPlugin extends GenericPlugin {
	/**
	 * Called as a plugin is registered to the registry
	 * @param $category String Name of category plugin was registered to
	 * @return boolean True iff plugin initialized successfully; if false,
	 * 	the plugin will not be registered.
	 */
	function register($category, $path) {
		$success = parent::register($category, $path);
		if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return true;
		if ($success && $this->getEnabled()) {
			
			// Insert ShowReviewers div
			HookRegistry::register('Templates::Article::Details', array($this, 'showReviewers'));
		
		}
		return $success;
	}

	/**
	 * Get the plugin display name.
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.generic.showReviewers.displayName');
	}

	/**
	 * Get the plugin description.
	 * @return string
	 */
	function getDescription() {
		return __('plugins.generic.showReviewers.description');
	}


	/**
	 * @copydoc PKPPlugin::getTemplatePath
	 */
	function getTemplatePath($inCore = false) {
		return parent::getTemplatePath($inCore) . 'templates/';
	}

	/**
	 * Add reviewer names to the template
	 * @param $hookName string
	 * @param $params array
	 */
	function showReviewers($hookName, $params) {
		$request = $this->getRequest();
		$context = $request->getContext();
				
		$smarty =& $params[1];
		$output =& $params[2];
		
		$article = $smarty->get_template_vars('article');
		
		$showReviewers = "";
			
		$reviewAssignmentDAO = DAORegistry::getDAO('ReviewAssignmentDAO');
		$reviewAssignments = $reviewAssignmentDAO->getBySubmissionId($article->getId());
		
		foreach ($reviewAssignments as $reviewAssignment) {
			if ($reviewAssignment->getDateCompleted() && $reviewAssignment->getDateAcknowledged()){
				$showReviewers .= $reviewAssignment->getReviewerFullName() . "<br />";				
			}
		}

		$smarty->assign('showReviewers', $showReviewers);
		
		$output .= $smarty->fetch($this->getTemplatePath() . 'showReviewers.tpl');
		return false;		
		
	}
}

?>
