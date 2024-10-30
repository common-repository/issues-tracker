<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Issues Tracker</title>
  <style>
    html {
      font-family: Helvetica, Arial, sans-serif;
      color: #414141;
    }

    .container {
      max-width: 540px;
      margin: 0 auto;
    }

    .wrapper {
      box-sizing: border-box;
      text-align: center;
      max-width: 600px;
      width: 100%;
      margin: 0 auto;
    }

    .wrapper .logo {
      margin-top: -100px;
    }

    h2 {
      font-size: 18px;
      font-weight: 700;
    }

    p {
      font-size: 14px;
      text-align: center;
    }

    table tr td p {
      text-align: left;
      padding-left: 10px;
    }

    p:first-child {
      text-align: left;
    }

    table {
      width: 100%;
      font-size: 14px;
    }

    table,
    th,
    td {
      border: 1px solid #b4b4b4;
      border-collapse: collapse;
    }

    .footer p {
      font-size: 12px;
      text-align: center;
    }

    a {
      color: #aea6da;
    }

    a:hover {
      text-decoration: underline;
    }

    .footer {
      background: linear-gradient(#2e82ef, #361cc1);
      padding: 24px;
      color: #fff;
    }

    .footer a {
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <img style="margin-bottom: -85px;"
      src="https://issues-tracker.top/wp-content/plugins/issues-tracker/assets/img/email-header.png" alt="email-header">

    <img src="https://issues-tracker.top/wp-content/plugins/issues-tracker/assets/img/email-404.png" alt="email-404">

    <div class="container">
      <p>Hi!</p>
      <h3>
        The Issues Tracker plugin has identified a new 404 error (Page Not Found) on your website {{istkr_website}}
      </h3>
      <table border=1>
        {{istkr_table}}
      </table>
      <p>
        Hurry up to fix this problem to keep high ranks in search engines if it's real page or post on your website.
      </p>
      <p>Thank you for using the Issues Tracker!</p>
    </div>

    <div class="container_footer"></div>

    <div class="footer">
      <p>
        Have any questions? Write us <a href="mailto:support@issues-tracker.top">support@issues-tracker.top</a>
        or fill up the <a href="https://issues-tracker.top/contact-us">contact form</a>
      </p>
      <p>Your Issues Tracker team</p>
    </div>
  </div>
</body>

</html>
