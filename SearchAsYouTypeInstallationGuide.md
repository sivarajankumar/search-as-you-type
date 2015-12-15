# Overview #
The new Search-as-you-Type (SayT) application allows you to add dynamic, real-time search to your Google Mini or Google Search Appliance. Your search box will dynamically present suggestions and auto-complete queries before the user is even done typing! In fact, we've architected it in such a way that you can use Search-as-you-Type on any text input field!

We've also designed the project so you can get it up and running with sample data out of the box.   Then you can later integrate it with your existing systems by hooking into a simple server side interface.

# System Requirements #
Since the bulk of the logic is all encompassed in the provided javascript file (search-as-you-type.js), this project could easily be adapted to any web serving stack you already have in place.  However to make it easier for you to visualize and implement a fully integrated solution, we've described the full setup including how to add the packaged XAMPP server side components if you don't have them.

The following are required to get Search-As-You-Type installed and running against the provided sample data:

  * Apache HTTP Server 2.2.4 or later
  * PHP 5.2.3 or later

We've referenced an easy packaged installation process for these below.  You can skip that section if you already have these available.

# Contents #
  1. readme.txt (this file)
  1. sayt/search-as-you-type.js (the main javascript file with the search-as-you-type logic)
  1. search-responder.php (server component that returns search suggestions to the browser)
  1. test.html (sample page with a search box for testing your installation)
  1. test-data.txt (sample data file)
  1. images/ (directory of image resources for the suggestions UI)
  1. styles/ (directory of style resource for the suggestions UI)


# Getting Started #
To get started with Search-As-You-Type just follow these simple steps:

  1. Download and extract the distribution of this project from http://code.google.com/p/search-as-you-type/downloads/list
  1. If you don't already have the prerequisite Apache HTTP Server and PHP installed and available, follow these instructions to conveniently install them auto-configured to work together.
  1. Replace the {resourcesPath} token in search-as-you-type.js with the URL to your Search-As-You-Type web directory (i.e. http://localhost/sayt/)
  1. Replace the {ajaxResponderUrl} token in search-as-you-type.js with URL of your search-responder file (i.e. http://localhost/sayt/search-responder.php)
  1. Install the provided sayt directory onto your web server.  If you followed the installation instructions referred to in step 2 above, then this can be done by copying the sayt directory under 

&lt;xampp-install-dir&gt;

/xampplite/htdocs/
  1. Run the sample queries suggested below to verify that you have Search-As-You-Type running correctly


# Installation of Apache HTTP Server & PHP #
If you don't already have Apache and PHP installed, then the XAMPP project makes it easy to get them installed and configured to run together.

Here are the steps for Windows environments:

  1. Download the XAMPP Lite zip file (1.6.3a or later) from http://www.apachefriends.org/en/xampp-windows.html#646
  1. Extract the zip file into a local directory, we'll call this directory 

&lt;xampp-install-dir&gt;


  1. Run 

&lt;xampp-install-dir&gt;

/xampplite/setup\_xampp.bat
  1. Run 

&lt;xampp-install-dir&gt;

/xampplite/apache\_start.bat to start the web server (If you get an error message it may be that you have another web server running that you'll need to shut down.  Check this FAQ article to help troubleshoot and remember to re-run the apache\_start script above once the issue has been resolved.)
  1. Verify that the Apache HTTP server is running correctly by loading http://localhost/ into your web browser and look for the XAMPP logo

This setup is for development purposes only.  You should take the necessary steps to security harden your installation of these components before pushing this to a production environment.  More info about doing this is at http://www.apachefriends.org/en/xampp-windows.html#1221

The analogous steps for Linux environments are similar and are described in detail at http://www.apachefriends.org/en/xampp-linux.html#374.  And the security hardening steps are described here: http://www.apachefriends.org/en/xampp-linux.html#381.

# Sample Data Queries #
First be sure you've gone through all of the steps in the Getting Started section above.

The sample data (test-data.txt) includes some sample information such as people and offices.  You can add any type of information you might need such as conference rooms, glossary definitions, and other query suggestions.  Be creative!

Make sure your web server is running as was described in the installation section above.

Now load http://localhost/sayt/test.html into your web browser.  Try typing T into the search box to see the suggestions.  Now type a 'u' and the word 'Tulsa' should autocomplete for you.

# Adding Search-As-You-Type to your Google Mini or Google Search Appliance Front End #
First, create a new test front end. In this new test front end, search for the section titled: `Search box input form` and replace all the text in that section (i.e. up to the section titled `Bottom search box`) with the following:
```
<xsl:template name="search_box">
  <xsl:param name="type"/>
  <form name="gs" method="GET" action="search">
        <table border="0" cellpadding="0" cellspacing="0">
          <xsl:if test="($egds_show_search_tabs != '0') and (($type = 'home') or ($type = 'std_top'))">
          <tr><td>
                <table cellpadding="4" cellspacing="0">
                  <tr><td>
                        <xsl:call-template name="desktop_tab"/>
                  </td></tr>
                </table>
          </td></tr>
          </xsl:if>
          <xsl:if test="($type = 'swr')">
          <tr><td>
                <table cellpadding="4" cellspacing="0">
                  <tr><td>
                    There were about <b><xsl:value-of select="RES/M"/></b> results for <b><xsl:value-of select="$space_normalized_query"/></b>.
                      <br/>
                    Use the search box below to search within these results.
                  </td></tr>
                </table>
          </td></tr>
          </xsl:if>
          <tr><td>
          <table cellpadding="0" cellspacing="0">
        <tr>
          <td valign="middle">
			<xsl:choose>
          <xsl:when test="($egds_show_search_tabs != '0') and (($type = 'home') or ($type = 'std_top'))">

          <font size="-1">
            <xsl:choose>
              <xsl:when test="($type = 'swr')">
                <input type="text" id='q' name="as_q" size="{$search_box_size}" maxlength="256" value=""/>
                <input type="hidden" name="q" value="{$qval}"/>
              </xsl:when>
              <xsl:otherwise>
                <input type="text" id='q' name="q" size="{$search_box_size}" maxlength="256" value="{$space_normalized_query}"/>
                          </xsl:otherwise>
                        </xsl:choose>
          </font>
          </xsl:when>
          <xsl:otherwise>
          <font size="-1">
            <xsl:choose>
              <xsl:when test="($type = 'swr')">
                <input type="text" name="as_q" size="{$search_box_size}" maxlength="256" value=""/>
                <input type="hidden" name="q" value="{$qval}"/>
              </xsl:when>
              <xsl:otherwise>
                <input type="text" name="q" size="{$search_box_size}" maxlength="256" value="{$space_normalized_query}"/>
                          </xsl:otherwise>
                        </xsl:choose>
          </font>

          </xsl:otherwise>
        </xsl:choose>
          </td>
          <xsl:call-template name="collection_menu"/>
          <td valign="middle">
          <font size="-1">
            <xsl:call-template name="nbsp"/>
              <xsl:choose>
              <xsl:when test="$choose_search_button = 'image'">
                        <input type="image" name="btnG" src="{$search_button_image_url}"
                       valign="bottom" width="60" height="26"
                       border="0" value="{$search_button_text}"/>
              </xsl:when>
              <xsl:otherwise>
                <input type="submit" name="btnG" value="{$search_button_text}"/>
              </xsl:otherwise>
              </xsl:choose>
          </font>
          </td>
                  <td nowrap="1">
                        <font size="-2">
                        <xsl:if test="(/GSP/RES/M > 0) and ($show_swr_link != '0') and ($type = 'std_bottom')">
                                <xsl:call-template name="nbsp"/>
                                <xsl:call-template name="nbsp"/>
                                <a href="{$swr_search_url}">
                                        <xsl:value-of select="$swr_search_anchor_text"/>
                                </a>
                                <br/>
                        </xsl:if>
                        <xsl:if test="$show_result_page_adv_link != '0'">
                                <xsl:call-template name="nbsp"/>
                                <xsl:call-template name="nbsp"/>
                                <a href="{$adv_search_url}">
                                        <xsl:value-of select="$adv_search_anchor_text"/>
                                </a>
                                <br/>
                        </xsl:if>
                        <xsl:if test="$show_alerts_link != '0'">
                                <xsl:call-template name="nbsp"/>
                                <xsl:call-template name="nbsp"/>
                                <a href="{$alerts_url}">
                                        <xsl:value-of select="$alerts_anchor_text"/>
                                </a>
                                <br/>
                        </xsl:if>
                        <xsl:if test="$show_result_page_help_link != '0'">
                                <xsl:call-template name="nbsp"/>
                                <xsl:call-template name="nbsp"/>
                                <a href="{$help_url}">
                                        <xsl:value-of select="$search_help_anchor_text"/>
                                </a>
                        </xsl:if>
                        <br/>
                        </font>
                  </td>
        </tr>
        <xsl:if test="$show_secure_radio != '0'">
        <tr>
          <td colspan="2">
          <font size="-1">Search:
            <xsl:choose>
              <xsl:when test="$access='p'">
                <label><input type="radio" name="access" value="p" checked="checked" />public content</label>
              </xsl:when>
              <xsl:otherwise>
                <label><input type="radio" name="access" value="p"/>public content</label>
              </xsl:otherwise>
            </xsl:choose>
            <xsl:choose>
              <xsl:when test="$access='a'">
                <label><input type="radio" name="access" value="a" checked="checked" />public and secure content</label>
              </xsl:when>
              <xsl:otherwise>
                <label><input type="radio" name="access" value="a"/>public and secure content</label>
              </xsl:otherwise>
            </xsl:choose>
          </font>
          </td>
        </tr>
        </xsl:if>
      </table>
  </td></tr>
</table>
    <xsl:text>
    </xsl:text>
    <xsl:call-template name="form_params"/>
</form>
</xsl:template>
```

Then search for the section titled: `Utility function for constructing copyright text` and replace all the text in that section (i.e. up to the section titled `Utility functions for generating html entities`) with the following:
```
<xsl:template name="copyright">
  <center>
    <br/><br/>
    <p>
    <font face="arial,sans-serif" size="-1" color="#2f2f2f">
      Powered by Google Search Appliance</font>
    </p>
  </center>
<script src='http://{YOUR_HOST_DIR}/search-as-you-type.js'></script>
<script>searchAsYouType.initialize(document.getElementById('q'), true);</script>
</xsl:template>
```

Finally, replace the {YOUR\_HOST\_DIR} text above with the location and directory of your search-as-you-type directory/files.

Now, once your test front end works, you can perform the same search and replace in your current front end stylesheet or custom front end stylesheet. Enjoy!

Adding Search-As-You-Type to any other search field or input text field
To any HTML text input field, add the following argument id='sayt'.


For instance:
```
  <input id='sayt' type='input'>
```


(If you already have an id, you can reuse that and change the 'sayt' field below.)


And then, below this input field, add the following 2 lines of code:
```
   <script src='http://localhost/sayt/search-as-you-type.js'></script>
   <script>searchAsYouType.initialize(document.getElementById('sayt'), true);</script>
```

Please keep in mind that Internet Explorer doesn't allow you to put a 

&lt;script&gt;

 that modifies the DOM inside an open tag (e.g. a <table> tag), so please be sure the above script calls are placed appropriately.<br>
<br>
And that's all there is to it!<br>
<br>
<h1>Basic customization: Adding your own data to the sample data file</h1>
Although we have provided a sample file (test-data.txt), we are sure that most of you will want more than just <code>Tom Cruise</code> showing up in your drop-down box.<br>
<br>
The format of this flat file is pretty simple.  It is a pipe (<code>|</code>) delimited file where each line is a record.<br>
<br>
The first field is the name of the query term.  This is what will be used if the query auto-completes.<br>
<br>
The second field is the type of query (e.g. <code>People</code>).  This affects the look-and-feel of those types of results as defined in your styles folder (see generic.css or customized.css).  For instance, you might want <code>People</code> results that show up in the drop-down box to have a yellow border and you might want information on conference rooms to have a green border.  Changing those color and style settings should be fairly straightforward once you open the aforementioned .css files.<br>
<br>
The third field is simply the html text of the content you'd like to show in the result box.  This can be as advanced as you like.  The sample data shows pretty basic HTML, but we encourage you to add images, tables, etc.  Your HTML can be as long as you'd like, however, the html code has to all remain on the one line in the flat file.<br>
<br>
The fourth and last field is the html link of that result - in other words, if the user uses the mouse or down-arrow to go to this result in the drop-down box and clicks on it, then where should they be taken.<br>
<br>
<h1>Advanced customization</h1>

The provided search-responder.php file is fairly lightweight.  Its role is simply to respond to a given query parameter ("query") by returning the appropriate suggestions or tab completion data to display for that query.  The benefit is that it is very easy to understand and can be edited easily.  The drawback is that it is inefficient for very large amounts of data.<br>
<br>
For very large numbers of results, a flat file can become inefficient, so using a database instead is the preferred solution.<br>
<br>
To do this, you can replace search-responder.php with your own basic implementation.  This can be using any server technology or architecture you'd like, with the only requirement being that the interface to the client (search-as-you-type.js) must remain the same.  In particular your server component (Java Servlet, CGI script, JSP page, etc) must accept a query parameter named "query" and it must return the appropriate data in the form of JSON encoded parameters in a javascript handler function call.<br>
<br>
<i>Notes:<br>
<ul><li>You may receive css warnings in older versions of FireFox (e.g. 1.5).  These should not cause any problems.<br>
</li><li>The bottom of the box (i.e. the shadow) may not appear on the search-as-you-type drop down box in Internet Explorer due to how IE sometimes handles relative paths in the .css file.  To ensure your images load correctly, simply edit styles/ie.css and make sure your image locations all have the absolute path to your images.</i>