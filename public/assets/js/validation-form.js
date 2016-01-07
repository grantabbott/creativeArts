var Validate = function () {
	var handleInstall = function() {
   		$('.install-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                },
	                password: {
	                    required: true,
	                    minlength: 6
	                },
	                username: {
	                    required: true,
	                    minlength: 4
	                },
	                mysql_username: {
	                    required: true,
	                },
	                mysql_password: {
	                    required: true,
	                },
	                hostname: {
	                    required: true,
	                },
	                mysql_database: {
	                    required: true,
	                },
	                envato_username: {
	                    required: true,
	                },
	                purchase_code: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleUsername = function() {
   		$('.username-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                username: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleUserProfileUpdate = function() {
   		$('.user-profile-update-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                alternate_email: {
	                    email: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleLogin = function() {
   		$('.login-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                username: {
	                    required: true,
	                },
	                password: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleRegister = function() {
   		$('.register-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                name: {
	                    required: true,
	                },
	                email: {
	                    required: true,
	                    email: true
	                },
	                username: {
	                    required: true,
	                    minlength: 4
	                },
	                password: {
	                    required: true,
	                    minlength: 6
	                },
	                password_confirmation: {
	                    required: true,
	                    equalTo: "#password"
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleForgot = function() {
   		$('.forgot-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                email: {
	                    required: true,
	                    email: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleResetPassword = function() {
   		$('.reset-password-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                email: {
	                    required: true,
	                    email: true,
	                },
	                password: {
	                    required: true,
	                    minlength: 6
	                },
	                password_confirmation: {
	                    required: true,
	                    equalTo: "#password"
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleLanguageEntry = function() {
   		$('.language-entry-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                text: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleLanguage = function() {
   		$('.language-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                locale: {
	                    required: true,
	                },
	                name: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}	

	var handleChangePassword = function() {

   		$('.change-password-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                old_password: {
	                    required: true,
	                },
	                new_password: {
	                    required: true,
	                },
	                new_password_confirmation: {
	                    required: true,
	                    equalTo: "#new_password"
	                },
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}		

	var handleUser = function() {

   		$('.user-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                name: {
	                    required: true,
	                },
	                role_id: {
	                    required: true,
	                },
	                username: {
	                    required: true,
	                    minlength: 4
	                },
	                email: {
	                    required: true,
	                    email: true
	                },
	                password: {
	                    required: true,
	                    minlength: 6
	                },
	                password_confirmation: {
	                    required: true,
	                    equalTo: "#password"
	                },
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}	


	var handleTicket = function() {
   		$('.ticket-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                department_id: {
	                    required: true,
	                },
	                ticket_type_id: {
	                    required: true,
	                },
	                ticket_subject: {
	                    required: true,
	                },
	                ticket_priority: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleArticle = function() {
   		$('.kb-article-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                kb_category_id: {
	                    required: true,
	                },
	                kb_article_title: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleTicketProperty = function() {
   		$('.ticket-property-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                department_id: {
	                    required: true,
	                },
	                ticket_type_id: {
	                    required: true,
	                },
	                ticket_priority: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleTicketReply = function() {
   		$('.ticket-reply-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                ticket_status: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleAnnoucement = function() {
   		$('.annoucement-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                annoucement_title: {
	                    required: true,
	                },
	                start_date: {
	                    required: true,
	                },
	                end_date: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handlePage = function() {
   		$('.page-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                page_title: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

    return {
        init: function () {
            handleInstall();
            handleUsername();
            handleLogin();
            handleRegister();
            handleChangePassword();
            handleForgot();
            handleResetPassword();
            handleUser();
            handleLanguage();
            handleLanguageEntry();
            handleTicket();
            handleUserProfileUpdate();
            handleArticle();
            handleTicketProperty();
            handleTicketReply();
            handleAnnoucement();
            handlePage();

            jQuery(document).on("click", ".alert_delete", function(e) {
	            var link = jQuery(this).attr("href"); 
	            e.preventDefault();    
	            bootbox.confirm("Deleting this entirty will result in deleting all linked data with it. It cannot be undone. Are you sure want to proceed? ", function(result) {    
	                if (result) {
	                    document.location.href = link;     
	                }    
	            });
	        });

	        
            jQuery(document).on("click", "[data-submit-confirm-text]", function(e) {
		        var $el = $(this);
		        e.preventDefault();
		        var confirmText = 'Deleting this entirty will result in deleting all linked data with it. It cannot be undone. Are you sure want to proceed? ';
		        bootbox.confirm(confirmText, function(result) {
		            if (result) {
		                $el.closest('form').submit();
		            }
		        });
		    });
        }
    };
}();
