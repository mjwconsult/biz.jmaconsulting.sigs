Email Signatures
================

This CiviCRM extension does one simple thing: it provides an email signature image for the current user when sending non-bulk emails.

Installation is done automatically via the built-in extension manager:

1. Click Administer > System Settings > Manage Extensions.
2. Click on Add New tab.
3. Beside Email Signatures extension, click Download, then Download and Install.
4. We recommend narrowing the contacts that have the Email Signature fieldset containing the Signature image field to a contact subtype that has permission to send emails. Navigate to Adminster > Customize Data and Screens > Custom fields, beside Email Signatures click more > Settings, then in Used For select the Individual contact sub-types who need to be able to use an email signature image when sending emails.

Use
---

Users who want to be able to insert an image of their signature should edit their contact information, click to open Email Signature fieldset, and upload a png or jpg file to the Signature image field and save.

Then when composing an image they can insert the Signature image token. The signature image file will be properly inserted into the outgoing email. 

Email templates containing the token can be saved and shared among users and the email sender's own signatures will be pulled in when emails from those templates are sent.

IMPORTANT NOTE: To allow users to view the Signature Image in their mails, you need to grant the 'CiviCRM: access uploaded files' permission to Authenticated and Anonymous users.
