"use strict";

// Class definition
var KTWizard1 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _validations = [];

	var initWizard = function () {
		// Initialize form wizard
		_wizard = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		$(".btn_edit").on('click', function(){
			var move_step = $(this).data('id');
			_wizard.goTo(move_step);
		})
		function update_tips(id){
			$(".tip").each(function(){
				$(".tip").addClass('hide')
			})
			$($(".tip")[id]).removeClass('hide');
		}
		function changeLabel(){
			// Preview Section
			$("#selected_business").text($('#business_name option:selected').text())
			$("#selected_camp_name").text($('#camp_name').val())
			$("#selected_camp_start").text($('.camp_start').val())
			$("#selected_number_weeks").text($('.num_weeks').val())
			$("#selected_camp_end").text($('.camp_end').val())
			$("#selected_weeks").text($('#selected_days').val())
            // Payment Method
            $(".p-method").find('input').each(function(){
                if($(this).prop('checked') == true){
					var selected_text = $(this).parent().text().trim();
                    $("#selected_method").text(selected_text);
					if(selected_text == 'Credit Card'){
						$("#btn_submit").text('Checkout');
					}
					else{
						$("#btn_submit").text('Go to Invoice page');
					}
                }
            })
            $(".sch").find('input').each(function(){
                if($(this).prop('checked') == true){
                    $("#selected_schedule").text($(this).parent().text().trim())
                }
            })
			// Manage Tips
			var currentStep = _wizard.currentStep;
			update_tips(currentStep - 1)
			if(currentStep == 2){
				$('.tips').removeClass('hide');
			} else {
				// $('.tips').addClass('hide');
			}
		}
		_wizard.on('beforeNext', function (wizard) {
			_validations[wizard.getStep() - 1].validate().then(function (status) {
				if (status == 'Valid') {
					_wizard.goNext();
					changeLabel()
					KTUtil.scrollTop();
				} else {
					Swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});

			_wizard.stop();  // Don't go to the next step
		});

		// Change event
		_wizard.on('change', function (wizard) {
			changeLabel()
			KTUtil.scrollTop();
		});
	}

	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					business_name: {
						validators: {
							notEmpty: {
								message: 'Business Name is required'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 2
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					camp_name: {
						validators: {
							notEmpty: {
								message: 'Campaign Name is required'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 3
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					start: {
						validators: {
							notEmpty: {
								message: 'Days of the Week is required'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 4
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					selected_days: {
						validators: {
							notEmpty: {
								message: 'Days of the Week is required'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

        // Step 5
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					selected_signs: {
						validators: {
							notEmpty: {
								message: 'Sign is required'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

        // Step 6
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					locaddress1: {
						validators: {
							notEmpty: {
								message: 'Address is required'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard_v1');
			_formEl = KTUtil.getById('kt_form');

			initWizard();
			initValidation();
		}
	};
}();

jQuery(document).ready(function () {
	KTWizard1.init();
});
