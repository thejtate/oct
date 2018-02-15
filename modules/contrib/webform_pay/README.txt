Description
-----------
This module provides a Payment component to Webform, allowing users to use
payment gateways provided by the Pay (http://drupal.org/project/pay) module.

Note that while this module does not store financial information (beyond credit
card type and last four digits), it does not make this module inherently secure.
Before accepting any kind of credit card payment, even if you're immediately
sending it to another site like PayPal or Authorize.net, you MUST obtain a
valid SSL certificate for your transactions to be secure between the user's
browser and the server (https). Webform Pay does not enforce this requirement.

Requirements
------------
Webform module (3.x)
Pay module

Installation
------------
1. Copy the entire webform_pay directory the Drupal sites/all/modules directory.

2. Login as an administrator. Enable the module in the "Administer" -> "Site
   Building" -> "Modules"

3. Ensure that you have at least one payment gateway set up properly within the
   Pay module settings under "Administer" -> "Site configuration" -> "Payment
   settings"

4. Create a new webform node or edit an existing one. Visit the "Webform" tab
   and add a new component of the type "Payment information". Select the payment
   gate way configured in Step 3 that this Webform will use for payment.

   When configuring this type of component, you must "map" the value fields from
   other fields within the webform. You may select as many components as you
   like for the "value" to be charged. The total of these components will be
   added up and charged to the user.

   Other fields may also be mapped, such as a billing address, phone number, and
   first and last names. Considering the number of fields that may be mapped,
   it is recommended to add Payment information components after all other
   components have been set up.

5. Save the component and view your form. If payment is not processed upon
   filling out the form, check your payment gateway settings that were
   configured in Step 3.

Support
-------
Post support requests to the module issue queue at:
http://drupal.org/project/issues/webform_pay?status=All

Please search the existing issues before posting new requests.


