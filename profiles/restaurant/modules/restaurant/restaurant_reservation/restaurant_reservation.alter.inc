<?php

/**
 * Alter hooks for restaurant_reservation.
 */

/**
 * Implements hook_form_alter().
 */
function restaurant_reservation_form_eck__entity__form_add_reservation_reservation_alter(&$form, &$form_state, $form_id) {
  // When the form is not shown on admin pages, make some changes.
  if (!drupal_match_path(current_path(), "admin/structure/entity-type/reservation/reservation/*")) {
    // Set the status to pending by default.

    $language = $form['field_reservation_status']['#language'];
    $form['field_reservation_status'][$language]['#value'] = 'pending';
    $form['field_reservation_status'][$language]['#access'] = FALSE;

    // Change the value of the submit buttton.
    $form['actions']['submit']['#value'] = t('Submit Reservation');

    // Only show the locations dropdown if site has created locations.
    if (isset($form['field_reservation_location'])) {
      $options = $form['field_reservation_location'][$language]['#options'];

      // Remove the _none options if set.
      unset($options['_none']);

      $form['field_reservation_location']['#access'] = count($options);
    }

    // Add a custom submit callback.
    $form['#submit'][] = 'restaurant_reservation_form_eck__entity__form_add_reservation_reservation_submit';
  }
}

/**
 * Custom submit callback for reservation form.
 */
function restaurant_reservation_form_eck__entity__form_add_reservation_reservation_submit($form, &$form_state) {
  global $user;
  // Clear all messages.
  drupal_get_messages();

  // Show a custom message.
  //drupal_set_message(panopoly_config_get('reservation_form_success_message', ''));

  // Redirect to the reservation page.
  $form_state['redirect'] = current_path();

  //ligthspeed implementation
  $tz = new DateTimeZone(/*date_default_timezone_get());/*/$form['field_reservation_date']['und'][0]['value']['#date_timezone']);
  $now = new DateTime($form['field_reservation_date']['und'][0]['#entity']->field_reservation_date['und'][0]['value'],$tz);//'#default_value']['value'],$tz);
  $PostQopen = new DateTime();
  $PostQopen->setTimezone(new DateTimeZone($form['field_reservation_date']['und'][0]['value']['#date_timezone']));//date_default_timezone_get()));
  $PostQopen->setTimestamp(strtotime('today 8:30am'));
  $PostQClose = new DateTime();
  $PostQClose->setTimezone(new DateTimeZone($form['field_reservation_date']['und'][0]['value']['#date_timezone']));//date_default_timezone_get()));
  $PostQClose->setTimestamp(strtotime('today 10:30pm'));
  $now->modify('-5 hour');

if($PostQopen <= $now && $PostQClose >=$now){
  $in_an_hour = clone $now;
  $in_an_hour->modify('+1 hour');
  $reserv = array();
  $values = array();
  $reserv['date'] = $now->format('c');
  $reserv['date_end'] =  $in_an_hour->format('c');
  $reserv['message'] = "".$form['field_reservation_message']['und'][0]['value']['#value'];
  $reserv['name'] = "".$form['field_reservation_name']['und'][0]['value']['#value'];
  $reserv['lastname'] =$form['field_reservation_lastname']['und'][0]['value']['#value']; "".
  $reserv['party_size'] = "".$form['field_reservation_party_size']['und'][0]['value']['#value'];
  $reserv['phone'] = "".$form['field_reservation_phone']['und'][0]['value']['#value'];
  $reserv['email'] = "".$form['field_reservation_email']['und'][0]['email']['#value'];

  $tok = _lightspeed_restaurant_get_token();

  if(user_is_anonymous()){
    $res = _lightspeed_restaurant_get_customer($tok,trim($reserv['email']));
    $values['fname'] = "".$form['field_reservation_name']['und'][0]['value']['#value'];
    $values['lname'] = "".$form['field_reservation_lastname']['und'][0]['value']['#value'];
    $values['phone'] = "".$form['field_reservation_phone']['und'][0]['value']['#value'];
    $values['email'] = "".$form['field_reservation_email']['und'][0]['email']['#value'];
    if(empty($res['results'])){
          $cid = _lightspeed_restaurant_create_customer($tok, $values);
    }else{
          $cid = $res['results'][0]['id'];
    }
  }elseif(user_is_logged_in()){
    $user_full = user_load($user->uid); // user_load(uid) returns the complete array
    $res = _lightspeed_restaurant_get_customer($tok,trim($user->mail));
    $values['fname'] = "".$user_full->field_given_name['und'][0]['value'];
    $values['lname'] = "".$user_full->field_lastname['und'][0]['value'];
    $values['phone'] = "".$user_full->field_telephone['und'][0]['value'];
    $values['email'] = "".$user->mail;
    //$cid = '32049';
    if(empty($res['results'])){
          $cid = _lightspeed_restaurant_create_customer($tok, $values);
    }else{
          $cid = $res['results'][0]['id'];
    }

  }
  $reservation = _lightspeed_restaurant_create_reservation($tok,$cid,$reserv);
  drupal_set_message(panopoly_config_get('reservation_form_success_message', ''));
  
  $user_fields = user_load(1);

   $body = '<html>
               <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" bgcolor="#ffffff" >
               <p>Cottage Hillstation</p><br>
               <p>Date: '.$reserv['date'].'</p><br>
               <p>Name: '.$values['fname'].'</p><br>
               <p>Lastname: '.$values['lname'].'</p><br>
               <p>Message: '.$reserv['message'].'</p><br>
               <p>Party size: '.$reserv['party_size'].'</p><br>
               <p>Telephone: '.$values['phone'].'</p><br>
               <p>email: '.$values['email'].'</p><br>
               </body></html>';
     
               $my_module = 'restaurant_reservation';
	       $my_mail_token = '';
	       $from = 'me@gmail.com';
	       
               $message = array(
		 'to' => '"'.addslashes(mime_header_encode('Test')) .'"<'.$user_fields->mail.'>',
		 'subject' => t('New Reservation has been created'),
		 'body' => $body,
		 'headers' => array(
		 'From' => 'me@gmail.com',
		 'MIME-Version' => '1.0',
		 'Content-Type' => 'text/html;charset=utf-8',),
	       );
	      
               $system = drupal_mail_system($my_module, $my_mail_token);
	       if ($system->mail($message)) {
	        	// Success.
	       }
	       else {
		 // Failure.
		}

}else{
    drupal_set_message(t("We only accept Reservations from from 8:30am to 10:30pm"));
    
}

}
