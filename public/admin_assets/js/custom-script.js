/*
 *  Document   : app.js
 *  Author     : pixelcave
 *  Description: UI Framework Custom Functionality (available to all pages)
 *
 */




















class CustomScript {
    static formValidation(formClass) {
        jQuery(formClass).validate({
            ignore: [],
            errorClass: 'help-block animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function (error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function (e) {
                var elem = jQuery(e);

                elem.closest('.form-group').removeClass('has-error').addClass('has-error');
                elem.closest('.help-block').remove();
            },
            success: function (e) {
                var elem = jQuery(e);

                elem.closest('.form-group').removeClass('has-error');
                elem.closest('.help-block').remove();
            }
        });
    }

    static dataTableWithPrint(className){
        jQuery(className).dataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "ordering": false,
            pageLength: -1,
            lengthMenu: [[5, 10, 15, 20,50,-1], [5, 10, 15, 20,50,'all']]
        });
    }

    static select2Validate(className) {
        jQuery(className).select2();
        jQuery(className).on('change', function () {
            jQuery(this).valid();
        });
    }

    static jsDatePicker(className) {
        jQuery(className).add('.input-daterange').datepicker({
            weekStart: 1,
            autoclose: true,
            todayHighlight: true
        });
    }

    static addLadgerFormValidation() {
        jQuery.validator.addMethod('lessThanOrEqual', function (value, element, param) {
            return (parseFloat(value) <= parseFloat(jQuery(param).val()));
        }, 'Can not greater than Debit');
        $('.add-ledger-form').validate({
            rules: {
                credit: {lessThanOrEqual: "#debit"}
            },
            ignore: [],
            errorClass: 'help-block animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function (error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function (e) {
                var elem = jQuery(e);

                elem.closest('.form-group').removeClass('has-error').addClass('has-error');
                elem.closest('.help-block').remove();
            },
            success: function (e) {
                var elem = jQuery(e);

                elem.closest('.form-group').removeClass('has-error');
                elem.closest('.help-block').remove();
            }
        });
    }

    static onChangeAddField(className) {
        jQuery(className).on('change', function () {
            var value = $(className).val();
            if (value == 1) {
                jQuery('.checkno-show-hide').html(`<div class="form-group">
                                <div class="col-sm-12">
                                    <div class="form-material form-material-primary">
                                        <input class="form-control" type="text" id="check_no"
                                               name="check_no" placeholder="Enter check no" required>
                                        <label for="check_no">Check No</label>
                                    </div>
                                </div>
                            </div>`);
            } else {
                jQuery('.checkno-show-hide').empty();
            }

        });
    }

    static onSubmitSweetAlert(data, className) {
        jQuery(className).submit(function (e) {
            var form = this;
            e.preventDefault();
            swal({
                title: data.title,
                text: data.text,
                showCancelButton: true,
                confirmButtonText: data.confirmButtonText,
                closeOnConfirm: false,
                html: false
            }, function () {
                form.submit();
            });

        });
    }
}
