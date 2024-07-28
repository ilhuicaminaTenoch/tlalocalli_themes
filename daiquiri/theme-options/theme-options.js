/* global jQuery, DAIQUIRI_STORAGE */

//-------------------------------------------
// Theme Options fields manipulations
//-------------------------------------------
jQuery(document).ready(function() {
	"use strict";

	// Toggle inherit button and cover
	jQuery('#daiquiri_options_tabs').on('click', '.daiquiri_options_inherit_lock,.daiquiri_options_inherit_cover', function (e) {
		var parent = jQuery(this).parents('.daiquiri_options_item');
		var inherit = parent.hasClass('daiquiri_options_inherit_on');
		if (inherit) {
			parent.removeClass('daiquiri_options_inherit_on').addClass('daiquiri_options_inherit_off');
			parent.find('.daiquiri_options_inherit_cover').fadeOut().find('input[type="hidden"]').val('');
		} else {
			parent.removeClass('daiquiri_options_inherit_off').addClass('daiquiri_options_inherit_on');
			parent.find('.daiquiri_options_inherit_cover').fadeIn().find('input[type="hidden"]').val('inherit');
			
		}
		e.preventDefault();
		return false;
	});

	// Refresh linked field
	jQuery('#daiquiri_options_tabs').on('change', '[data-linked] select,[data-linked] input', function (e) {
		var chg_name     = jQuery(this).parent().data('param');
		var chg_value    = jQuery(this).val();
		var linked_name  = jQuery(this).parent().data('linked');
		var linked_data  = jQuery('#daiquiri_options_tabs [data-param="'+linked_name+'"]');
		var linked_field = linked_data.find('select');
		var linked_field_type = 'select';
		if (linked_field.length == 0) {
			linked_field = linked_data.find('input');
			linked_field_type = 'input';
		}
		var linked_lock = linked_data.parent().parent().find('.daiquiri_options_inherit_lock').addClass('daiquiri_options_wait');
		// Prepare data
		var data = {
			action: 'daiquiri_get_linked_data',
			nonce: DAIQUIRI_STORAGE['ajax_nonce'],
			chg_name: chg_name,
			chg_value: chg_value
		};
		jQuery.post(DAIQUIRI_STORAGE['ajax_url'], data, function(response) {
			var rez = {};
			try {
				rez = JSON.parse(response);
			} catch (e) {
				rez = { error: DAIQUIRI_STORAGE['ajax_error_msg'] };
				console.log(response);
			}
			if (rez.error === '') {
				if (linked_field_type == 'select') {
					var opt_list = '';
					for (var i in rez.list) {
						opt_list += '<option value="'+i+'">'+rez.list[i]+'</option>';
					}
					linked_field.html(opt_list);
				} else {
					linked_field.val(rez.value);
				}
				linked_lock.removeClass('daiquiri_options_wait');
			}
		});
		e.preventDefault();
		return false;
	});
});


// Check for dependencies
//--------------------------------------------------------

// Check for external dependencies (for example, "Page template" in the page edit mode)
jQuery( window ).on( 'load', function() {
	"use strict";

	var attempts = 5,
		attempts_timer = setInterval( function() {
			if ( --attempts < 0 && attempts_timer ) {
				clearInterval( attempts_timer );
				attempts_timer = null;
				return;
			}
			jQuery( '.daiquiri_options .daiquiri_options_section' ).each( function () {
				daiquiri_options_check_dependencies( jQuery( this ) );
			} );
		}, 3000 );

} );

// Check for internal dependencies
jQuery( document ).ready( function() {
	"use strict";

	// Check all inner dependencies
	jQuery( '.daiquiri_options .daiquiri_options_section' ).each( function () {
		daiquiri_options_check_dependencies( jQuery( this ) );
	} );

	// Check dependencies on any field change
	jQuery( '.daiquiri_options .daiquiri_options_item_field [name^="daiquiri_options_field_"]' ).on( 'change', function () {
		daiquiri_options_check_dependencies( jQuery( this ).parents( '.daiquiri_options_section' ) );
	} );

	// Check dependencies on a field with a page template is appear
	jQuery( document ).on( 'trx_addons_action_page_template_selector_appear', function() {			
		jQuery( '.daiquiri_options .daiquiri_options_section' ).each( function () {
			daiquiri_options_check_dependencies( jQuery( this ) );
		} );
	} );

} );

// Check for dependencies
function daiquiri_options_check_dependencies(cont) {
	if ( typeof daiquiri_dependencies == 'undefined' || DAIQUIRI_STORAGE['check_dependencies_now'] ) {
		return;
	}
	DAIQUIRI_STORAGE['check_dependencies_now'] = true;
	cont.find( '.daiquiri_options_item_field,.daiquiri_options_group[data-param]' ).each( function() {
		var ctrl = jQuery( this ),
			id = ctrl.data( 'param' );
		if (id === undefined) {
			return;
		}
		var depend = false, fld;
		for (fld in daiquiri_dependencies) {
			if (fld == id) {
				depend = daiquiri_dependencies[id];
				break;
			}
		}
		if (depend) {
			var dep_cnt    = 0, dep_all = 0;
			var dep_cmp    = typeof depend.compare != 'undefined' ? depend.compare.toLowerCase() : 'and';
			var dep_strict = typeof depend.strict != 'undefined';
			var val        = undefined;
			var name       = '', subname = '';
			var parts      = '', parts2 = '';
			var i;
			fld = null;
			for (i in depend) {
				if (i == 'compare' || i == 'strict') {
					continue;
				}
				dep_all++;
				val     = undefined;
				name    = i;
				subname = '';
				if (name.indexOf( '[' ) > 0) {
					parts   = name.split( '[' );
					name    = parts[0];
					subname = parts[1].replace( ']', '' );
				}
				// If a name is a selector to the DOM-object 
				if ( name.charAt( 0 ) == '#' || name.charAt( 0 ) == '.' || name.slice( 0, 8 ) == '@editor/' ) {
					if ( name.charAt( 0 ) == '#' || name.charAt( 0 ) == '.' ) {
						fld = jQuery( name );
					}
					if ( fld && fld.length > 0 ) {
						var panel = fld.closest('.edit-post-sidebar');
						if ( panel.length === 0 ) {
							if ( ! fld.hasClass('daiquiri_inited') ) {
								fld.addClass('daiquiri_inited').on('change', function () {
									jQuery('.daiquiri_options .daiquiri_options_section').each( function () {
										daiquiri_options_check_dependencies(jQuery(this));
									} );
								} );
							}
						} else {
							if ( ! panel.hasClass('daiquiri_inited') ) {
								panel.addClass('daiquiri_inited').on('change', fld, function () {
									jQuery('.daiquiri_options .daiquiri_options_section').each( function () {
										daiquiri_options_check_dependencies(jQuery(this));
									} );
								} );
							}
						}
					} else if ( name == '#page_template' || name == '.editor-page-attributes__template select' || name.slice( 0, 8 ) == '@editor/' ) {
						var prop_check = 'template';
						if ( name.slice( 0, 8 ) == '@editor/' ) {
							prop_check = name.slice( 8 );
						}
						if ( typeof wp == 'object' && typeof wp.data == 'object' && typeof wp.data.select( 'core/editor' ) == 'object' ) {
							if ( typeof DAIQUIRI_STORAGE['editor_props'] == 'undefined' ) {
								DAIQUIRI_STORAGE['editor_props'] = {};
							}
							if ( typeof DAIQUIRI_STORAGE['editor_props'][ prop_check ] == 'undefined' ) {
								var prop_val = wp.data.select( 'core/editor' ).getEditedPostAttribute( prop_check );
								if ( prop_val !== undefined ) {
									DAIQUIRI_STORAGE['editor_props'][ prop_check ] = prop_val;
								}
							}
							val = typeof DAIQUIRI_STORAGE['editor_props'][ prop_check ] != 'undefined' ? DAIQUIRI_STORAGE['editor_props'][ prop_check ] : '';
							var $body = jQuery( 'body' );
							if ( ! $body.hasClass( 'daiquiri_editor_props_listener_inited' ) ) {
								$body.addClass( 'daiquiri_editor_props_listener_inited' );
								// Call a check_dependencies() on a page template is changed
								wp.data.subscribe( function() {
									var prop_val = wp.data.select( 'core/editor' ).getEditedPostAttribute( prop_check );
									if ( prop_val !== undefined && ( typeof DAIQUIRI_STORAGE['editor_props'][ prop_check ] == 'undefined' || prop_val != DAIQUIRI_STORAGE['editor_props'][ prop_check ] ) ) {
										DAIQUIRI_STORAGE['editor_props'][ prop_check ] = prop_val;
										jQuery('.daiquiri_options .daiquiri_options_section').each( function () {
											daiquiri_options_check_dependencies( jQuery( this ) );
										} );
									}

								} );
							}
						}
					}
				// A name is a field from options
				} else {
					fld = cont.find( '[name="daiquiri_options_field_' + name + '"]' );
				}
				if ( val !== undefined || ( fld && fld.length > 0 ) ) {
					if ( val === undefined ) {
						val = daiquiri_options_get_field_value( fld );
					}
					if ( val == 'inherit' ) {
						dep_cnt = 0;
						dep_all = 1;
						var parent = ctrl,
							tag;
						if ( ! parent.hasClass('daiquiri_options_group') ) {
							parent = parent.parents('.daiquiri_options_item');
						}
						var lock = parent.find( '.daiquiri_options_inherit_lock' );
						if ( lock.length ) {
							if ( ! parent.hasClass( 'daiquiri_options_inherit_on' ) ) {
								lock.trigger( 'click' );
							}
						} else if ( ctrl.data('type') == 'select' ) {
							tag = ctrl.find('select');
							if ( tag.find('option[value="inherit"]').length && tag.val() != 'inherit' ) {
								tag.val('inherit').trigger('change');
							}
						} else if ( ctrl.data('type') == 'radio' ) {
							tag = ctrl.find('input[type="radio"][value="inherit"]');
							if ( tag.length && ! tag.get(0).checked ) {
								ctrl.find('input[type="radio"]:checked').get(0).checked = false;
								tag.get(0).checked = true;
								tag.trigger('change');
							}
						}
						break;
					} else {
						if (subname !== '') {
							parts = val.split( '|' );
							for (var p = 0; p < parts.length; p++) {
								parts2 = parts[p].split( '=' );
								if (parts2[0] == subname) {
									val = parts2[1];
								}
							}
						}
						if ( typeof depend[i] != 'object' && typeof depend[i] != 'array' ) {
							depend[i] = { '0': depend[i] };
						}
						for (var j in depend[i]) {
							if (
								(depend[i][j] == 'not_empty' && val !== '')   // Main field value is not empty - show current field
								|| (depend[i][j] == 'is_empty' && val === '') // Main field value is empty - show current field
								|| (val !== '' && ( ! isNaN( depend[i][j] )   // Main field value equal to specified value - show current field
												? val == depend[i][j]
												: (dep_strict
														? val == depend[i][j]
														: ('' + val).indexOf( depend[i][j] ) === 0
													)
											)
								)
								|| (val !== '' && ("" + depend[i][j]).charAt( 0 ) == '^' && ('' + val).indexOf( depend[i][j].substr( 1 ) ) == -1)
																			// Main field value not equal to specified value - show current field
							) {
								dep_cnt++;
								break;
							}
						}
					}
				} else {
					dep_all--;
				}
				if (dep_cnt > 0 && dep_cmp == 'or') {
					break;
				}
			}
			if ( ! ctrl.hasClass('daiquiri_options_group') ) {
				ctrl = ctrl.parents('.daiquiri_options_item');
			}
			var section = ctrl.parents('.daiquiri_tabs_section'),
				tab = jQuery( '[aria-labelledby="' + section.attr('aria-labelledby') + '"]' );
			if (((dep_cnt > 0 || dep_all === 0) && dep_cmp == 'or') || (dep_cnt == dep_all && dep_cmp == 'and')) {
				ctrl.slideDown().removeClass( 'daiquiri_options_no_use' );
				if ( section.find('>.daiquiri_options_item:not(.daiquiri_options_item_info),>.daiquiri_options_group[data-param]').length != section.find('.daiquiri_options_no_use').length ) {
					if ( tab.hasClass( 'daiquiri_options_item_hidden' ) ) {
						tab.removeClass('daiquiri_options_item_hidden');
					}
				}
			} else {
				ctrl.slideUp().addClass( 'daiquiri_options_no_use' );
				if ( section.find('>.daiquiri_options_item:not(.daiquiri_options_item_info),>.daiquiri_options_group[data-param]').length == section.find('.daiquiri_options_no_use').length ) {
					if ( ! tab.hasClass( 'daiquiri_options_item_hidden' ) ) {
						tab.addClass('daiquiri_options_item_hidden');
						if ( tab.hasClass('ui-state-active') ) {
							tab.parents('.daiquiri_tabs').find(' > ul > li:not(.daiquiri_options_item_hidden)').eq(0).find('> a').trigger('click');
						}
					}
				}
			}
		}

		// Individual dependencies
		//------------------------------------

		// Remove 'false' to disable color schemes less then main scheme!
		// This behavious is not need for the version with sorted schemes (leave false)
		if (false && id == 'color_scheme') {
			fld = ctrl.find( '[name="daiquiri_options_field_' + id + '"]' );
			if (fld.length > 0) {
				val     = daiquiri_options_get_field_value( fld );
				var num = daiquiri_options_get_field_value( fld, true );
				cont.find( '.daiquiri_options_item_field' ).each(
					function() {
						var ctrl2 = jQuery( this ), id2 = ctrl2.data( 'param' );
						if (id2 == undefined) {
							return;
						}
						if (id2 == id || id2.substr( -7 ) != '_scheme') {
							return;
						}
						var fld2 = ctrl2.find( '[name="daiquiri_options_field_' + id2 + '"]' ),
						val2     = daiquiri_options_get_field_value( fld2 );
						if (fld2.attr( 'type' ) != 'radio') {
							fld2 = fld2.find( 'option' );
						}
						fld2.each(
							function(idx2) {
								var dom_obj      = jQuery( this ).get( 0 );
								dom_obj.disabled = idx2 !== 0 && idx2 < num;
								if (dom_obj.disabled) {
									if (jQuery( this ).val() == val2) {
										if (fld2.attr( 'type' ) == 'radio') {
											fld2.each(
												function(idx3) {
													jQuery( this ).get( 0 ).checked = idx3 === 0;
												}
											);
										} else {
											fld2.each(
												function(idx3) {
													jQuery( this ).get( 0 ).selected = idx3 === 0;
												}
											);
										}
									}
								}
							}
						);
					}
				);
			}
		}
	} );
	DAIQUIRI_STORAGE['check_dependencies_now'] = false;
}

// Return value of the field or number (index) of selected item (if second param is true)
function daiquiri_options_get_field_value(fld, num) {
	var item = fld.parents( '.daiquiri_options_item' );
	var ctrl = fld.parents( '.daiquiri_options_item_field' );
	var val  = fld.attr( 'type' ) == 'checkbox' || fld.attr( 'type' ) == 'radio'
			? (ctrl.find( '[name^="daiquiri_options_field_"]:checked' ).length > 0
				? (num === true
					? ctrl.find( '[name^="daiquiri_options_field_"]:checked' ).parent().index() + 1
					: (ctrl.find( '[name^="daiquiri_options_field_"]:checked' ).val() !== ''
						&& '' + ctrl.find( '[name^="daiquiri_options_field_"]:checked' ).val() != '0'
							? ctrl.find( '[name^="daiquiri_options_field_"]:checked' ).val()
							: 1
						)
					)
				: 0
				)
			: (num === true ? fld.find( ':selected' ).index() + 1 : fld.val());
	if ( item.length && item.hasClass( 'daiquiri_options_inherit_on' ) ) {
		val = num === true ? 0 : 'inherit';
	} else if (val === undefined || val === null) {
		val = num === true ? 0 : '';
	}
	return val;
}
