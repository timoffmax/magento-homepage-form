define([
    'underscore',
    'jquery',
    'Magento_Ui/js/form/form',
    'mageUtils',
    'Magento_Ui/js/modal/alert',
], function(_, $, form, utils, alert) {
    'use strict';

    return form.extend({
        defaults: {
            formUrl: '',
        },

        initialize: function () {
            this._super();

            return this;
        },

        getTitle() {
            return 'Homepage Form';
        },

        /**
         * Validates each element and returns true, if all elements are valid.
         */
        validate: function () {
            this.source.set('params.invalid', false);
            this.source.trigger('timoffmax-homepage-form.data.validate');
            this.focusInvalid();

            return !this.source.get('params.invalid');
        },

        /**
         * Submits the form if it's valid
         */
        submit: function () {
            if (false === this.validate()) {
                return;
            }

            this.makeRequest()
        },

        /**
         * Makes ajax request
         *
         * @returns {*}
         */
        makeRequest: function() {
            var save = $.Deferred();

            let data = this.source.get(this.dataScope);
            data = utils.serialize(data);
            data['form_key'] = $('input[name=form_key]').val();

            $('body').trigger('processStart');

            $.ajax({
                method: 'POST',
                url: this.formUrl,
                data: data,
                dataType: 'json',

                success: function (response) {
                    if (response.ajaxExpired) {
                        window.location.href = response.ajaxRedirect;
                    }

                    if (!response.error) {
                        alert({
                            title: $.mage.__('Success'),
                            content: $.mage.__(response.message),
                            actions: {
                                always: function(){}
                            }
                        });

                        return true;
                    } else {
                        alert({
                            title: $.mage.__('Error'),
                            content: $.mage.__(response.message),
                            actions: {
                                always: function(){}
                            }
                        });
                    }
                },

                error: function () {
                    alert({
                        title: $.mage.__('An error occurred :('),
                        content: $.mage.__('Request failed'),
                        actions: {
                            always: function(){}
                        }
                    });
                },

                complete: function () {
                    $('body').trigger('processStop');
                }
            });

            return save.promise();
        },
    });
});
