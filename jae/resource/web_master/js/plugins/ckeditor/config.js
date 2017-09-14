/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    // The toolbar groups arrangement, optimized for two toolbar rows.
    
    config.toolbarGroups = [
        { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
        //{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
        { name: 'links' },
        { name: 'insert' },
       // { name: 'forms' },
        //{ name: 'tools' },
        { name: 'document',   groups: [ 'mode', 'document', 'doctools' ] },
        //{ name: 'others' },
        //'/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'colors' },
        { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
        { name: 'styles' },
        //{ name: 'about' }
    ];
    
    config.allowedContent = true;
    config.removePlugins = 'smiley,flash,iframe';
    config.removeButtons = 'Underline,Subscript,Superscript,Print,Preview,Search,Save,NewPage';

    // Se the most common block elements.
    config.format_tags = 'p;h1;h2;h3;pre';
    // Make dialogs simpler.
    config.removeDialogTabs = 'image:advanced;link:advanced';
};
