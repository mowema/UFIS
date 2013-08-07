<div>
    <div>This is an advanced Email Action for ChronoForms v4 on Joomla! 2.5.
    It has the same basic functions as the standard Email Action but adds more features
    and uses slightly different code in the configuration.</div>
    <h4>The General tab</h4>
    <ul>
        <li>Use the Enabled drop-down to enable or disable individual emails.</li>
        <li>The Conditional box is a new feature that allows you to make emails conditional on form inputs. Enter {input_name}::value to set a condition e.g. {send_email}::Yes. The Email will only be sent if the condition is met exactly. For reliabiity please test for text strings or numbersd greater than zero, tests for empty strings '', 0 or 'false' will not be reliable.</li>
        <li>The Action label is used to identity Email Setups in the Form Events view.</li>
        <li>The Send As drop-down sets the email type as Plain text, HTML, or both.</li>
        <li>The Individual emails options will send a separate email to each recipient if checked; otherwise all the recipients will be incuded on the same email.</li>
        <li>The Check MX box adds a check to Dynamic email addresses to make sure that there is a valid Mailserver MX record for the domain. It offers some protection against users entering false addresses - but not if the address uses a valid domain.</li>
        <li>The File Attachments box allows you to set one or more files to be attached to the email. You can enter a input name in curly brackets e.g. <tt>{input_file_1}</tt>, a file path for an existing file, a comma separated list of entries, or the special <tt>{file_array}</tt> entry.
            <p>File paths can use the <tt>{#path#}</tt> placeholder to shorten the path. This will be replaced by the path to the Joomla! root folder - see the help under the box for the current value.</p>
            <p>The special <tt>{file_array}</tt> entry will load one or more files from paths pre-defined in <tt>$form->data['file_array']</tt>.</p></li>
        <li>The Get Submitter's IP box will either attach the IP Adresss to the end of the email or replace any <tt>{IPADDRESS}</tt> placeholder in the email template.</li>
        <li>The <b>Filter the email body</b> box is checked by default. It enables a filter of the email body HTML that will remove anything except text and basic HTML as a security check. It will remove any <tt>&lt;style&gt;</tt> tags so you will need to disable the filter if you need to include them. Styles added as attributes to the HTML e.g. s<tt>style="color: blue;"</tt> are not affected.</li>
    </ul>
    <h4>The Email Setup tab</h4>
    <ul>
        <li>The Dynamic and Static tabs have been merged into an Email Setup tab. </li>
        <li>The boxes on the Email Setup tab will accept either a string e.g. <tt>user@example.com</tt> or an input name in curly brackets <tt>{input_text_1}</tt>. This lets you mix and match static and dynamic values. </li>
        <li>The one special case is the From Email box which will only accept a valid email address. Using a dynamic From Email address is the most frequent cause of failed emails. Use a dynamic Reply To Name and Reply To Email to make it easy to reply to the form submitter. Note: If you are an experienced user and you need to use the dynamic From Email box you can enable the curly brackets by adding <tt>##OK##</tt> to the box.</li>
        <li>The To, CC, BCC and Reply To Email boxes will take a comma separated list of email addresses; you can mix and match static and dynamic addresses e.g. <tt>info@example.com</tt>, <tt>{email}, admin@mydomain.com</tt> Dynamic addresses must return valid email addresses as (a) a single address, (b) a comma separated list of addresses or (c) an array of single addresses. </li>
        <li>The Reply To Name box will take a comma separated list of names. These should match the list of ReplyTo Email addresses; if there are more Reply To Email addesses than names then the email addresses will be copied to the Name.</li>
        <li>The Subject, From Name and Reply To Name boxes take a text string which may include form input names in curly brackets e.g. <tt>Message from {name}</tt></li>

        <li>Only the To email input is required. Default values will be set for other boxes.</li>
    </ul>
    <h4>The Template tab</h4>
    <ul>
        <li>The template tab is the same as the standard Email Action and uses the Template Generator code from the standard action.</li>
        <li>Click the 'Add/Remove editor' link at the top to turn the Rich Editor on or off. Note that you cannot use PHP tags in the box with the Rich Editor on.</li>
        <li>You can use input names in curly brackets e.g. <tt>{input_text_1}</tt> anywhere in this box.</li>
    </ul>
</div>
