"use strict";

// Class definition
var KTWizard1 = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _validations = [];

	// Private functions
	var initWizard = function () {
		// Initialize form wizard
		_wizard = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizard.on('beforeNext', function (wizard) {
            _wizard.stop();
			_validations[wizard.getStep() - 1].validate().then(function (status) {
				if (status == 'Valid') {
					if(wizard.getStep() == 1){
						$('.btn-skip').removeClass('btn-hide');
						$('.btn-skip').addClass('btn-show');
					}
					if(wizard.getStep() == 2){
						$('.btn-skip').addClass('btn-hide');
						$('.btn-skip').removeClass('btn-show');
					}
                    if(wizard.getStep() == 1 && jQuery.inArray( 1, steps ) === -1){
                        steps.push(1)
                        $(".fc-text").text(fc[1])
                        $(".btn-init").click();
                    }
                    else if(wizard.getStep() == 2 && jQuery.inArray( 2, steps ) === -1){
                        steps.push(2)
                        $(".fc-text").text(fc[2])
                        $(".btn-init").click();
                    }
					_wizard.goNext();
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
			if(wizard.getStep() == 1 || wizard.getStep() == 3){
				$('.btn-skip').addClass('btn-hide');
				$('.btn-skip').removeClass('btn-show');
			}
			else{
				$('.btn-skip').removeClass('btn-hide');
				$('.btn-skip').addClass('btn-show');
			}
			KTUtil.scrollTop();
		});
		$(".btn-skip").on('click', function(){
			if(_wizard.getStep() == 2){
				$('.btn-skip').addClass('btn-hide');
				$('.btn-skip').removeClass('btn-show');
				// submit_form();
				// return;
			}
			_wizard.goNext()
		})
	}

	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					bill_name: {
						validators: {
							notEmpty: {
								message: 'Billing Contact is required'
							}
						}
					},
					bill_email: {
						validators: {
							notEmpty: {
								message: 'Billing Contact Email is required'
							},
                            emailAddress : {
                                message : "The value is not a valid email address"
                            }
						}
					},
					category : {
						validators: {
							notEmpty: {
								message: 'Category is required'
							},
						}
					},
					bill_phone: {
						validators: {
							notEmpty: {
								message: 'Billing Contact Phone is required'
							},
                            phone : {
                                country: 'US',
                                message : "The value is not a valid US phone number",
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
					package: {
						validators: {
							notEmpty: {
								message: 'Package details is required'
							}
						}
					},
					weight: {
						validators: {
							notEmpty: {
								message: 'Package weight is required'
							},
							digits: {
								message: 'The value added is not valid'
							}
						}
					},
					width: {
						validators: {
							notEmpty: {
								message: 'Package width is required'
							},
							digits: {
								message: 'The value added is not valid'
							}
						}
					},
					height: {
						validators: {
							notEmpty: {
								message: 'Package height is required'
							},
							digits: {
								message: 'The value added is not valid'
							}
						}
					},
					packagelength: {
						validators: {
							notEmpty: {
								message: 'Package length is required'
							},
							digits: {
								message: 'The value added is not valid'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 3
		// _validations.push(FormValidation.formValidation(
		// 	_formEl,
		// 	{
		// 		fields: {
		// 			delivery: {
		// 				validators: {
		// 					notEmpty: {
		// 						message: 'Delivery type is required'
		// 					}
		// 				}
		// 			},
		// 			packaging: {
		// 				validators: {
		// 					notEmpty: {
		// 						message: 'Packaging type is required'
		// 					}
		// 				}
		// 			},
		// 			preferreddelivery: {
		// 				validators: {
		// 					notEmpty: {
		// 						message: 'Preferred delivery window is required'
		// 					}
		// 				}
		// 			}
		// 		},
		// 		plugins: {
		// 			trigger: new FormValidation.plugins.Trigger(),
		// 			bootstrap: new FormValidation.plugins.Bootstrap()
		// 		}
		// 	}
		// ));

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
