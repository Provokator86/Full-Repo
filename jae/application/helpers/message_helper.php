<?php
/*
+---------------------------------------------------------------+
| For site error and success massege list						|
+---------------------------------------------------------------+
| Return all the message list if called with blank parameter	|
+---------------------------------------------------------------+
| Return only the matching message if called by key				|
+---------------------------------------------------------------+
| Author: SWI Dev												|
+------------------------------+--------------------------------+
| Date: 2-JUNE-2015            | Modified on:                   |
+------------------------------+--------------------------------+
*/

function get_message($key = '')
{
	$message = array(
						'save_success' 					=> t('Information has been saved.'),
			    		'save_failed' 					=> t('Failed to save your information.'),
						'del_success' 					=> t('Information has been removed.'),
						'del_failed' 					=> t('Information has failed to removed.'),
                        'no_result'                     => t('No information found.'),
                        'login_greet'                   => t('Please login with your Username and Password.'),
                        'forgot_greet'                  => t('Please provide email to receive new password.'),
                        'confirmation'                  => t('Are you sure to delete this'),
                        'restore_confirm'               => t('Are you sure you want to restore access to default'),
                        'approve_confirmation'          => t('Are you sure you want to approve this business'),
                        'apply_approve_confirmation'    => t('Are you sure you want to apply for approval of this business'),
						'doc_uploaded' 				    => t('A new document has been uploaded successfully. Once you will press the "save changes" button, then it will be saved permanently.'),
                        'usr_typ_emt'                   => t('The user must have at least one user role assigned.'),
                        'ofc_num_er'                    => t('Please provide office#.'),
                        'dup_rc_rm'                     => t('Duplicate record discarded.'),
                        'country_state'                 => t('Please select Country and State/Province first.'),
                        'county_exist'                  => t('The county already exists. Please select this county.'),
                        'biz_img_uploaded'              => t('A new image has been uploaded successfully. Once you will press the "save changes" button, then it will be saved permanently.'),
                        'biz_doc_uploaded'              => t('A new doc has been uploaded successfully. Once you will press the "save changes" button, then it will be saved permanently.'),
                        'applied_for_approved'          => t('Business has been sent successfully for approval.'),
                        'business_approved'             => t('Business has been approved successfully.'),
						'unable_to_apply'               => t('Unable to sent business for approval. Please try again later.'),
                        'first_name'                    => t('Please provide first name.'),
                        'last_name'                     => t('Please provide last name.'),
                        'email'                         => t('Please provide valid email.'),
                        'zipcode'                       => t('Please provide zip/postal code.'),
                        'password'                      => t('Please provide password.'),
                        'con_pass'                      => t('Password and confirm password must be same.'),
                        'buyer_alreay_added'            => t('Buyer already tagged with this business.'),
                        'select_buyer'                  => t('Please select buyer to add him/her with this business.'),
                        'contact_save_success'          => t('Information has been send successfully.'),
                        'buyer_reg_success'             => t('Registration has been successful. Please check your email for login details and registration confirmation email.'),
                        'buyer_login_failed'            => t('Login failed. Please check your username or password.'),
                        'username_not_exist'            => t('Sorry! Username does not found.'),
                        'password_reset'                => t('Password has been reset successfully and sent to #EMAIL#'),
                        'comment_sent'                  => t('Your comment/question has been sent successfully.'),
                        'verified'                      => t('Congratulations! You have successfully verified your email address. Please login to continue.'),
                        'verification_failed'           => t('Sorry verification failed. Please try latter. Contact us if any problem persist.'),
                        'loggedin'                      => t('Please loggedin first.'),
                        'biz_exist'                     => t('Business already saved to your saved business list.'),
					);
					
	return $key == '' ? $message : $message[$key];
}