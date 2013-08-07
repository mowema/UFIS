<h4>Changelog</h4>
<ul>
<li><span class='gh_date' >13 Dec 2011</span> : fixed bug with CC &amp; BCC addresses in Joomla! 1.5</li>
<li><span class='gh_date' >11 Jan 2012</span> : fixed bug with 'continue' in Conditional test, updated help</li>
<li><span class='gh_date' >02 Feb 2012</span> : added over-ride for Dynamic From Email and added Template Generator button</li>
<li><span class='gh_date' >14 Feb 2012</span> : updated send error message to show Joomla! exception report</li>
<li><span class='gh_date' >31 Mar 2012</span> : added 'Individual emails' option</li>
<li><span class='gh_date' >&nbsp;</span> : added language files</li>
<li><span class='gh_date' >20 Apr 2012</span> : fixed bugs in HTML filter, from name and error messages</li>
<li><span class='gh_date' >22 Apr 2012</span> : added parsing for nested curly brackets e.g. <tt>{a.b.c}</tt></li>
<li><span class='gh_date' >&nbsp;</span> : added curly bracket support for Reply To Email and fixed label in debug output</li>
<li><span class='gh_date' >&nbsp;</span> : added support for multiple Reply To Emails</li>
<li><span class='gh_date' >&nbsp;</span> : fixed bug where Admin Reply to was added by using <tt>JFactory::getMailer()</tt></li>
<li><span class='gh_date' >01 May 2012</span> : removed two lines of debug text left by mistake</li>
<li><span class='gh_date' >03 Jun 2012</span> : fixed a bug with sending individual emails</li>
<li><span class='gh_date' >&nbsp;</span> : added support for MX check on dynamic addresses</li>
<li><span class='gh_date' >14 Jun 2012</span> : re-added support for Joomla! 1.5</li>
<li><span class='gh_date' >22 Jul 2012</span> : removed multi-language hack that is no longer needed</li>
<li><span class='gh_date' >23 Jul 2012</span> : fixed bug with MX check, it was always applied</li>
<li><span class='gh_date' >02 Aug 2012</span> : fixed bug with attachments to allow <tt>{xxx}. . .{yyy}</tt> in a file path</li>
<li><span class='gh_date' >19 Oct 2012</span> : fixed bug with dynamic From Email including ##OK## in the email address</li>
<li><span class='gh_date' >22 Oct 2012</span> : added the ability to attach multiple files from $form->data['file_array']</li>
<li><span class='gh_date' >&nbsp;</span> : added an option to bypass the email body filter</li>
<li><span class='gh_date' >07 Mar 2013</span> : fixed a bug where an empty ReplyTo Name caused a PHP warning </li>
</ul>