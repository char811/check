$(document).ready(function(){
    $('.mobile').mask('0(000)-000-00-00');


    $('.registrationForm').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: 'Please another name',
                validators: {
                    notEmpty: {
                        message: 'Name required'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'Name must be from 6 to 30'
                    },
                    regexp: {
                        regexp: /^[a-zA-ZА-яА-я0-9]+$/,
                        message: 'Name can be only nmbers and litters'
                    },
                    different: {
                        field: 'password',
                        message: 'Name and pass can\'t be same'
                    }
                }
            },
            first_name: {
                message: 'Please another first_name',
                validators: {
                    stringLength: {
                        min: 1,
                        max: 30,
                        message: 'First_name must be from 1 to 30'
                    },
                    regexp: {
                        regexp: /^[a-zA-ZА-яА-я0-9]+$/,
                        message: 'First_name can be of numbers and litters'
                    }
                }
            },
            last_name: {
                message: 'Please another last_name',
                validators: {
                    stringLength: {
                        min: 1,
                        max: 30,
                        message: 'Last_name must be from 1 to 30'
                    },
                    regexp: {
                        regexp: /^[a-zA-ZА-яА-я0-9]+$/,
                        message: 'Last_name can be of numbers and litters'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email required'
                    },
                    emailAddress: {
                        message: 'Please another email'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Pass required'
                    },
                    identical: {
                        field: 'password_confirmation',
                        message: 'Passwords must match'
                    },
                    different: {
                        field: 'username',
                        message: 'The password cannot be the same as username'
                    },
                    stringLength: {
                        min: 8,
                        message: 'Pass must be of 8 symbols'
                    }
                }
            },
            password_confirmation: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and cannot be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'Repeat correctly your pass'
                    }
                }
            },
            mobile: {
                message: 'Please another mobile',
                validators: {
                    notEmpty: {
                        message: 'Mobile required'
                    },
                    stringLength: {
                        min: 15,
                        max: 30,
                        message: 'Mobile must be of 11 numbers'
                    },
                    regexp: {
                        regexp: /^[0-9-()]+$/,
                        message: 'Mobile must be only of numbers'
                    }
                }
            },
            comment: {
                message: 'Please another message',
                validators: {
                    notEmpty: {
                        message: 'Message required'
                    },
                    stringLength: {
                        min: 10,
                        max: 1000,
                        message: 'Message must be from 10 to 1000 symbols'
                    }
                }
            },
               service: {
                message: 'Please another service',
                validators: {
                    notEmpty: {
                        message: 'Service required'
                    }
                }
            },
               city: {
                message: 'Please another city',
                validators: {
                    notEmpty: {
                        message: 'City required'
                    }
                }
            }
        }
    });
});