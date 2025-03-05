
window.vad = window.vad || {};

( function( exports, $ ) {

    /**
     *
     *
     * @type {Object}
     */
    exports.Filter_Common = {

        /**
         * [start description]
         *
         * @return {[type]} [description]
         */
        start: function () {
            this.setupGlobals();

            // Listen to events ("Add hooks!")
            this.addListeners();
        },

        /**
         * [setupGlobals description]
         *
         * @return {[type]} [description]
         */
        setupGlobals: function ()
        {
            this.metas = {};
            this.filters = {};

            if( filter_data.metas !== '[]' ) {
                this.metas = JSON.parse(filter_data.metas, (key,value) => {
                    return value;
                });
            }

            if( filter_data.filters !== '[]' ) {
                this.filters = JSON.parse(filter_data.filters, (key,value) => {
                    return value;
                });
            }

            if( this.filters!=null && Object.keys(this.filters).length  ) {
                Object.entries(this.filters).forEach(([key, value]) => {
                    this.editFilterLabels( key );
                });
            }

        },

        /**
         * [addListeners description]
         */
        addListeners: function () {

            /** Page actions **/
            $(document).on('click', '.filter-item, .remove-filter-item',  this.handleFilterClick.bind(this));

            $(document).on('keyup', 'form.uk-search .uk-search-input',  this.handleKeyUp.bind(this));
            $(document).on('click', 'form.uk-search .uk-search-icon',  this.handleSearchClick.bind(this));

            $(window).on("popstate", this.handleBackButton.bind(this));

        },

        handleBackButton:function(e) {
            e.preventDefault();
            this.filterProducts();
            this.__updateUrl( );
        },

        handleKeyUp:function(e) {
            if (13 === e.which) {
                e.preventDefault();
                this.filterProducts();
                this.__updateUrl( );
            }
        },


        handleSearchClick :function(e) {
            e.preventDefault();
            this.filterProducts();
            this.__updateUrl( );
        },

        handleFilterClick :function(e) {
            e.preventDefault();

            const button = $(e.currentTarget);
            button.toggleClass('uk-active');

            this.editFilterInputs(button.data('cat'), button.data('term'), button.data('label'));
            this.filterProducts();
            this.__updateUrl( );
        },

        editFilterInputs :function(category, term, value) {

            const currentFilters = this.filters.hasOwnProperty(category)  ? this.filters[category]:[];
            const newFilter = term.toString();

            if (currentFilters.hasOwnProperty(newFilter)) {
                delete currentFilters[newFilter];
                if( Object.keys(currentFilters).length===0 ) {
                    delete this.filters[category];
                }

            } else {
                if( ! this.filters.hasOwnProperty(category) ) {
                    const obj = { [category] : { [newFilter] : [value] } }
                    this.filters = Object.assign( this.filters, obj );
                }
                else this.filters[category][newFilter]= value;
            }


            this.editFilterLabels( category );

        },

        editFilterLabels: function( category ) {
            $('.filter-active').empty();

            if( this.filters.hasOwnProperty(category) && this.filters[category] != null ) {
                Object.entries(this.filters[category]).forEach(([key, value]) => {
                    $('#tax-'+category+' a.filter-item[data-term="'+key+'"]').addClass('uk-active');
                } );
            }

            const hasActiveChild = $('#tax-'+category).find('ul a.uk-active').length > 0;

            if (hasActiveChild) {
                $('#tax-'+category +' > a').addClass('uk-active');
            } else {
                $('#tax-'+category +' > a').removeClass('uk-active');
            }
        },

        filterProducts: function( data ) {

            if( !data || typeof data !== 'object' ) {
                data = {};
            }

            jQuery.ajax({
                type: 'POST',
                url: filter_data.ajaxurl,
                context: this,
                data: Object.assign(data, {
                    action: filter_data.action,
                    filter: this.filters,
                    metas: this.metas,
                    s: this.__getSearch(),
                    query_args: filter_data.query_args,
                    security:filter_data.nonce
                } ),
                success: function(res) {
                    res = JSON.parse(res);
                    if( res.html !=='' ){
                        $('#result-count').html(res.total);
                        $('.ntdst-filter-results').html(res.html);
                        $('.pagination').html(res.page);
                    }
                },
                error: function(err) {
                    console.error(err);
                }
            })
        },

        __getSearch: function(  ) {
            return $('form.uk-form input[name="s"]').val();
        },

        __updateUrl: function( ) {

            let qry = {};
            let query = '?';
            let search = this.__getSearch();

            Object.assign( qry, this.metas  );
            Object.assign( qry, this.filters  );
            if( search != '' ) {
                Object.assign( qry, { s: search }  );
            }

            Object.entries(qry).forEach(([key, value]) => {
                if(value!=undefined) {
                    if( typeof value === 'object' ) {
                        value = Object.keys(value).toString();
                    }
                    query+=(query==='?'?'':"&")+key+"="+value;
                }
            });

            if (history.pushState) {
                const newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + query;
                window.history.pushState({path:newurl},'',newurl);
            }

        }
    };

    $( document ).ready(function() {
        exports.Filter_Common.start();
    });


} )( vad, jQuery );
