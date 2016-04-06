/* global jQuery:false, window:false, document:false */

/*
 @package      Utility_Pro
 @author       Gary Jones
 @license      GPL-2.0+
 @link         http://gamajo.com/

 Hat tip to https://john-dugan.com/jquery-plugin-boilerplate-explained/ for the explanations.

 The semi-colon before the function invocation is a safety net against
 concatenated scripts and/or other plugins which may not be closed properly.

 "undefined" is used because the undefined global variable in ECMAScript 3
 is mutable (ie. it can be changed by someone else). Because we don't pass a
 value to undefined when the anonymous function is invoked, we ensure that
 undefined is truly undefined. Note, in ECMAScript 5 undefined can no
 longer be modified.

 "window" and "document" are passed as local variables rather than global.
 This (slightly) quickens the resolution process.
*/

;(
    function( $, window, document, undefined ) {
        'use strict';

        /*
         Store the name of the plugin in the "pluginName" variable. This
         variable is used in the "Plugin" constructor below, as well as the
         plugin wrapper to construct the key for the "$.data" method. It is
         also used as the event namespace.

         More: http://api.jquery.com/jquery.data/
         */
        var pluginName   = 'gamajoResponsiveAccessibleMenu',
            hoverTimeout = [];

        /*
         Create a lightweight plugin wrapper around the "Plugin" constructor,
         preventing against multiple instantiations.

         More: http://learn.jquery.com/plugins/basic-plugin-creation/
         */
        $.fn[ pluginName ] = function( options ) {
            this.each( function() {
                if ( ! $.data( this, 'plugin_' + pluginName ) ) {
                    /*
                     Use "$.data" to save each instance of the plugin in case
                     the user wants to modify it. Using "$.data" in this way
                     ensures the data is removed when the DOM element(s) are
                     removed via jQuery methods, as well as when the user leaves
                     the page. It's a smart way to prevent memory leaks.

                     More: http://api.jquery.com/jquery.data/
                     */
                    $.data( this, 'plugin_' + pluginName, new Plugin( this, options ) );
                }
            } );

            /*
             "return this;" returns the original jQuery object. This allows
             additional jQuery methods to be chained.
             */
            return this;
        };

        /*
         Attach the default plugin options directly to the plugin object. This
         allows users to override default plugin options globally, instead of
         passing the same option(s) every time the plugin is initialized.

         For example, the user could set the "property" value once for all
         instances of the plugin with
         "$.fn.pluginName.defaults.property = 'myValue';". Then, every time
         plugin is initialized, "property" will be set to "myValue".

         More: http://learn.jquery.com/plugins/advanced-plugin-concepts/
         */
        $.fn[ pluginName ].defaults = {
            l10n: {
                buttonText: 'Menu',
                buttonLabel: 'Menu',
                subMenuLabel: 'Sub Menu',
                subMenuButtonLabel: 'Menu',
                subMenuButtonText: 'Sub Menu',
            },
            hoverClass: 'menu-item-hover',
            hoverDelay: 250,
            navSelector: '.nav-primary',
            menuItemClass: 'menu-item',
            parentItemClass: 'menu-item-has-children',
            subMenuClass: 'sub-menu',
            mainMenuButtonClass: 'menu-toggle',
            subMenuButtonClass: 'sub-menu-toggle',
            screenReaderClass: 'screen-reader-text',
            slideSpeed: 'fast',
            superfishSelector: '.js-superfish',
            superfishArgs: {
                'delay': 100,
                'dropShadows': false,
                'animation': {
                    'opacity': 'show',
                    'height': 'show'
                }
            }
        };

        /*
         The "Plugin" constructor, builds a new instance of the plugin for the
         DOM node(s) that the plugin is called on. For example,
         "$('h1').pluginName();" creates a new instance of pluginName for
         all h1's.
         */
        // Create the plugin constructor
        function Plugin( element, options ) {
            /*
             Provide local access to the DOM node(s) that called the plugin,
             as well local access to the plugin name and default options.
             */
            this.element   = element;
            this._name     = pluginName;
            this._defaults = $.fn[ pluginName ].defaults;
            /*
             The "$.extend" method merges the contents of two or more objects,
             and stores the result in the first object. The first object is
             empty so that we don't alter the default options for future
             instances of the plugin.

             More: http://api.jquery.com/jquery.extend/
             */
            this.opts = $.extend( {}, this._defaults, options );

            /*
             The "init" method is the starting point for all plugin logic.
             Calling the init method here in the "Plugin" constructor function
             allows us to store all methods (including the init method) in the
             plugin's prototype. Storing methods required by the plugin in its
             prototype lowers the memory footprint, as each instance of the
             plugin does not need to duplicate all of the same methods. Rather,
             each instance can inherit the methods from the constructor
             function's prototype.
             */
            this.init();
        }

        // Avoid Plugin.prototype conflicts
        $.extend( Plugin.prototype, {
            // Initialization logic.
            init: function() {
                /*
                 Create additional methods below and call them via
                 "this.myFunction(arg1, arg2)", ie: "this.buildCache();".

                 Note, you can access the DOM node(s), plugin name, default
                 plugin options and custom plugin options for a each instance
                 of the plugin by using the variables "this.element",
                 "this._name", "this._defaults" and "this.options" created in
                 the "Plugin" constructor function (as shown in the buildCache
                 method below).
                 */
                this.buildConstants();
                this.buildCache();
                this.createToggleButtons();
                this.insertToggleButtons();
                this.buildButtonsCache();
                this.addAttributes();
                this.bindEvents();
            },

            // Remove plugin instance completely.
            destroy: function() {
                /*
                 The destroy method unbinds all events for the specific instance
                 of the plugin, then removes all plugin data that was stored in
                 the plugin instance using jQuery's .removeData method.

                 Since we store data for each instance of the plugin in its
                 instantiating element using the $.data method (as explained
                 in the plugin wrapper below), we can call methods directly on
                 the instance outside of the plugin initalization, ie:
                 $('selector').data('plugin_myPluginName').someOtherFunction();

                 Consequently, the destroy method can be called using:
                 $('selector').data('plugin_myPluginName').destroy();
                 */
                this.unbindEvents();
                this.$element.removeData();
            },

            // Setup known values.
            buildConstants: function() {
                this.ariaPressed  = 'aria-pressed';
                this.ariaExpanded = 'aria-expanded';
                this.ariaLabel    = 'aria-label';
            },

            // Cache DOM nodes for performance.
            buildCache: function() {
                /*
                 Create variable(s) that can be accessed by other plugin
                 functions. For example, "this.$element = $(this.element);"
                 will cache a jQuery reference to the element that initialized
                 the plugin. Cached variables can then be used in other methods.
                 */
                this.$element    = $( this.element );
                this.$nav        = $( this.opts.navSelector );
                this.$subMenu    = $( '.' + this.opts.subMenuClass );
                this.$parentItem = $( '.' + this.opts.parentItemClass );
            },

            // Cache more DOM nodes for performance. This needs to run after the toggle buttons have been created
            buildButtonsCache: function() {
                this.$mainMenuButton = $( '.' + this.opts.mainMenuButtonClass );
                this.$subMenuButton  = this.$nav.find( '.' + this.opts.subMenuButtonClass );
            },

            // Bind events that trigger methods.
            bindEvents: function() {
                /*
                 Bind event(s) to handlers that trigger other functions, ie:
                 "this.$element.on('click', function() {});". Note the use of
                 the cached variable we created in the buildCache method.

                 All events are namespaced, ie:
                 ".on('click'+'.'+this._name', function() {});".
                 This allows us to unbind plugin-specific events using the
                 unbindEvents method below.
                 */

                // These first few are not working yet?
                $( this.element )
                    .on( 'mouseenter.' + this._name, '.' + this.opts.menuItemClass, this.opts, this.menuItemEnter )
                    .on( 'mouseleave.' + this._name, '.' + this.opts.menuItemClass, this.opts, this.menuItemLeave )
                    .find( 'a' )
                    .on( 'focus.' + this._name + ', blur.' + this._name, this.opts, this.menuItemToggleClass );

                $( window ).on( 'resize.' + this._name, this, doResize ).triggerHandler( 'resize.' + this._name );
                this.$mainMenuButton.on( 'click.' + this._name, this, mainmenuToggle );
                this.$subMenuButton.on( 'click.' + this._name, this, submenuToggle );
            },

            // Unbind events that trigger methods.
            unbindEvents: function() {
                /*
                 Unbind all events in our plugin's namespace that are attached
                 to "this.$element".
                 */
                this.$element.off( '.' + this._name );
            },

            // Create the toggle button markup.
            createToggleButtons: function() {
                this.toggleButtons = {
                    menu: $( '<button />', {
                        class: this.opts.mainMenuButtonClass,
                        'aria-controls': this.$nav.attr( 'id' ),
                        'aria-expanded': false,
                        'aria-label': this.opts.l10n.buttonLabel,
                        'aria-pressed': false
                    } ).append( this.opts.l10n.buttonText ),
                    submenu: $( '<button />', {
                        class: this.opts.subMenuButtonClass,
                        'aria-expanded': false,
                        'aria-label': this.opts.l10n.subMenuButtonLabel,
                        'aria-pressed': false
                    } ).append( $( '<span />', {
                        class: this.opts.screenReaderClass,
                        text: this.opts.l10n.subMenuButtonText
                    } ) )
                }
            },

            // Insert toggle buttons into markup.
            insertToggleButtons: function() {
                this.$nav.before( this.toggleButtons.menu ); // Add the main nav button.
                this.$nav.find( '.' + this.opts.subMenuClass ).before( this.toggleButtons.submenu ); // Add the submenu nav button.
            },

            // Add attributes to existing elements.
            addAttributes: function() {
                $( '.' + this.opts.mainMenuButtonClass ).each( addClassID );
                // Give the UL a label, stops Voiceover reading out every item from the parent item.
                this.$subMenu.attr( this.ariaLabel, this.opts.l10n.subMenuLabel );
                // Give the LI a label, so Voiceover doesn't repeat the block-level text.
                this.$parentItem.attr( this.ariaLabel, function( i, val ) {
                    return $( this ).children( 'a' ).text();
                } );
            },

            /**
             * Add class to menu item on hover so it can be delayed on mouseout.
             *
             * @since 1.0.0
             */
            menuItemEnter: function( event ) {
                // Clear all existing hover delays
                $.each( hoverTimeout, function( index ) {
                    $( '#' + index ).removeClass( event.data.hoverClass );
                    clearTimeout( hoverTimeout[ index ] );
                } );
                // Reset list of hover delays
                hoverTimeout = [];

                $( this ).addClass( event.data.hoverClass );
            },

            /**
             * After a short delay, remove a class when mouse leaves menu item.
             *
             * @since 1.0.0
             */
            menuItemLeave: function( event ) {
                var $self               = $( this );
                // Delay removal of class
                hoverTimeout[ this.id ] = setTimeout( function() {
                    $self.removeClass( event.data.hoverClass );
                }, event.data.hoverDelay );
            },

            /**
             * Toggle menu item class when a link fires a focus or blur event.
             *
             * @since 1.0.0
             */
            menuItemToggleClass: function( event ) {
                $( this ).parents( '.' + event.data.menuItemClass ).toggleClass( event.data.hoverClass );
            }
        } );

        // The functions below are private, at least for now.

        /**
         * Add nav class and ID to related button.
         * @private
         */
        function addClassID() {
            var $this = $( this ),
                nav   = $this.next( 'nav' ),
                id    = 'class';
            $this.addClass( $( nav ).attr( 'class' ) );
            if ( $( nav ).attr( 'id' ) ) {
                id = 'id';
            }
            $this.attr( 'id', 'mobile-' + $( nav ).attr( id ) );
        }

        /**
         * Change Skiplinks and Superfish.
         */
        function doResize( event ) {
            var buttons = $( 'button[id^=mobile-]' ).attr( 'id' );

            if ( typeof buttons === 'undefined' ) {
                return;
            }

            superfishToggle( buttons, event.data.opts.superfishArgs, event.data.opts.superfishSelector );
            changeSkipLink( buttons );
            maybeClose( buttons, event.data );
        }

        /**
         * Action to happen when the main menu button is activated.
         */
        function mainmenuToggle( event ) {
            var $this = $( this );

            toggleBool( $this, event.data.ariaPressed );
            toggleBool( $this, event.data.ariaExpanded );
            $this.next( event.data.opts.navSelector ).slideToggle( event.data.opts.slideSpeed );
        }

        /**
         * Action for sub-menu toggles.
         */
        function submenuToggle( event ) {
            var $this  = $( this ),
                others = $this.closest( '.' + event.data.opts.menuItemClass ).siblings();

            toggleBool( $this, event.data.ariaPressed );
            toggleBool( $this, event.data.ariaExpanded );
            $this.next( '.' + event.data.opts.subMenuClass ).slideToggle( event.data.opts.slideSpeed );

            // Close sibling submenus.
            others.find( '.' + event.data.opts.subMenuButtonClass ).attr( event.data.ariaPressed, 'false' );
            others.find( '.' + event.data.opts.subMenuClass ).slideUp( event.data.opts.slideSpeed );
        }

        /**
         * Activate / deactivate Superfish.
         */
        function superfishToggle( buttons, superfishArgs, superfishSelector ) {
            // Check if Superfish has been loaded.
            if ( typeof $( superfishSelector ).superfish !== 'function' ) {
                return;
            }

            if ( ! isDisplayNone( buttons ) ) {
                superfishArgs = 'destory';
            }

            $( superfishSelector ).superfish( superfishArgs );
        }

        /**
         * Modify Genesis skip links to point to mobile buttons if they are visible, and back to the menu if not.
         */
        function changeSkipLink( buttons ) {
            var startLink = 'genesis-nav',
                endLink   = 'mobile-genesis-nav';

            if ( isDisplayNone( buttons ) ) {
                startLink = 'mobile-genesis-nav';
                endLink   = 'genesis-nav';
            }

            $( '.genesis-skip-link a[href^="#' + startLink + '"]' ).each( function() {
                var link = $( this ).attr( 'href' );
                link     = link.replace( startLink, endLink );
                $( this ).attr( 'href', link );
            } );
        }

        function maybeClose( buttons, plugin ) {
            if ( ! isDisplayNone( buttons ) ) {
                return;
            }

            $( '.' + plugin.opts.mainMenuButtonClass + ', .' + plugin.opts.subMenuButtonClass )
                .attr( plugin.ariaExpanded, 'false' )
                .attr( plugin.ariaPressed, 'false' );
            $( plugin.opts.navSelector + ', .' + plugin.opts.subMenuClass ).attr( 'style', '' );
        }

        /**
         * Generic function to get the display value of an element.
         *
         * @param  {string} id ID to check
         * @return {boolean}   True if display: none;, false otherwise.
         */
        function isDisplayNone( id ) {
            var element = document.getElementById( id ),
                style   = window.getComputedStyle( element );

            return 'none' === style.getPropertyValue( 'display' );
        }

        /**
         * Toggle boolean attributes.
         *
         * @param  {string} $element   Element to target.
         * @param  {string} attribute Attribute to toggle.
         * @return {string}
         */
        function toggleBool( $element, attribute ) {
            $element.attr( attribute, function( index, value ) {
                return 'false' === value ? 'true' : 'false';
            } );
        }
    }
)( jQuery, window, document );
