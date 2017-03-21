(function($) {
    
    $.entwine(function($) {
        
        /**
         * Class: .cms-edit-form .field.switchable
         *
         * Hide each switchable field except for the currently selected media type
         */
        $('.cms-edit-form .field.switchable').entwine({
            onmatch: function() {
                
                // get the form
                form = this.closest('form');
                
                // hide elements with class "Video" if Video has not been selected as MediaType
                if(this.hasClass('Video')){
                    
                    if(form.find('input[name=MediaType]:checked').val() !== 'Video') {
                        this.hide();
                    }
                
                }
                
                // hide elements with class "Audio" if Audio has not been selected as MediaType
                if(this.hasClass('Audio')){

                    if(form.find('input[name=MediaType]:checked').val() !== 'Audio') {
                        this.hide();
                    }
                
                }

                this._super();
            },
            disappear: function() {
                this.slideUp(200);
            },
            reappear: function() {
                this.slideDown(200);
            }
        });
        
        /**
         * Input: .cms-edit-form input[name=LinkType]
         *
         * On click of radio button, show selected field, hide all others
         */
        $('.cms-edit-form input[name=MediaType]').entwine({
            onclick: function() {
                
                // get value and form
                var id = this.val(),
                form = this.closest('form');
                
                // hide all and show the relevant ones
                form.find('.field.switchable').disappear();
                form.find('.field.switchable.' + id).reappear();

                this._super();
            }
        });
        
    });
    
})(jQuery);