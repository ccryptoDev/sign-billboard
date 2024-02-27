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

		function update_tips(id){
			$(".tip, .tips").each(function(){
				$(".tip, .tips").addClass('hide-container')
			})
			$($(".tip")[id]).removeClass('hide-container');
			$(".tips").each(function(){
				$(".tips").addClass('hide-container')
			})
			if(id != 0){
				$($(".tips")[id - 1]).removeClass('hide-container');
			}
		}
		function changeLabel(){
			// Preview Section
			$("#selected_business").text($('#t_bus_name option:selected').text())
			$("#selected_schedule").text($('#t_temp_name option:selected').text())
			$('#schedule').find("input").each(function(){
				if($(this).prop('checked') == true){
					$("#selected_schedule").text($(this).parent().text().trim())
				}
			})
			$('#restrict').find("input").each(function(){
				if($(this).prop('checked') == true){
					if($(this).val() == 1){
						$("#selected_location").text('No, allow this Ad to be placed in all locations that I choose in my Campaign.');
					}
					else{
						$("#selected_location").text($(this).parent().text().trim())
					}
				}
			})
			// Manage Tips
			var currentStep = _wizard.currentStep;
			update_tips(currentStep - 1);
			if(currentStep == 4){
				$("#btn-next").text("Next")
			}
			else{
				$("#btn-next").text("Next")
			}
		}
		_wizard.on('beforeNext', function (wizard) {
			_validations[wizard.getStep() - 1].validate().then(function (status) {
				if (status == 'Valid') {
					if(wizard.getStep() == 2){
						if($('#overlay_img').prop('files').length == 0){
							Swal.fire({
								text: "Please upload image",
								icon: "error",
								buttonsStyling: false,
								confirmButtonText: "Ok, got it!",
								customClass: {
									confirmButton: "btn font-weight-bold btn-light"
								}
							}).then(function () {
								KTUtil.scrollTop();
							});
							return;
						}
						KTApp.blockPage({
							overlayColor: 'white',
							opacity: 1,
							state: 'danger',
							message: 'Please wait...'
						});
						$("#temp_body").css("position", "fixed");
						var innerWidth = window.innerWidth;
						var con_width = $(".content").width();
						if(innerWidth >= 1200){
							$(".content").css('width',1000);
						}
						var element = $("#dis_img")[0];
						var rect = element.getBoundingClientRect();
						var canvas = document.createElement("canvas");

						canvas.width = $("#dis_img").width();
						canvas.height = $("#dis_img").height();
						var ctx = canvas.getContext("2d");
						ctx.translate(-rect.left,-rect.top);
						ctx.webkitImageSmoothingEnabled = false;
						ctx.mozImageSmoothingEnabled = false;
						ctx.imageSmoothingEnabled = false;
						html2canvas(element,{
							dpi: 144,
							allowTaint: true,
							removeContainer: true,
							backgroundColor: null,
							imageTimeout: 15000,
							logging: true,
							useCORS: true,
							scale : 2,

							scrollX:0, scrollY: -window.scrollY ,

							canvas:canvas,
							width : $("#dis_img").width(),
							height : $("#dis_img").height()
						}).then(function(canvas) {
							var base64URL = canvas.toDataURL("image/png");
							$.ajax({
								url: '/convert_img',
								type: 'post',
								headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
								tranditional: true,
								data : {
									image : base64URL,
									file : $('#overlay_img').prop('files')[0]['type'],
									status : status
								},
								success : function (res) {
									console.log(res)
									if(innerWidth >= 1200){
										$(".content").css('width', con_width);
									}
									$("#temp_body").css("position", "relative");
									KTApp.unblockPage();
									if(res['success'] == true){
										_wizard.goNext();
										changeLabel()
										KTUtil.scrollTop();
										$("#preview_img").attr("src",'/upload/'+res['file_name']);
										$("#img_name").val(res['file_name']);
									}
									else {
										toastr.error(res['message']);
									}
								}
							})
						})
					} else{
						_wizard.goNext();
						changeLabel()
						KTUtil.scrollTop();
					}
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
					template_name: {
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
					delivery: {
						validators: {
							notEmpty: {
								message: 'Delivery type is required'
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
