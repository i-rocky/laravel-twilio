<!DOCTYPE html>
<html>
<head>
    <title>Twilio Client Quickstart</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Share+Tech+Mono);

        body,
        p {
            padding: 0;
            margin: 0;
        }

        body {
            background: #272726;
        }

        div#controls {
            padding: 3em;
            max-width: 1200px;
            margin: 0 auto;
        }

        div#controls div {
            float: left;
        }

        div#controls div#call-controls,
        div#controls div#info {
            width: 16em;
            margin: 0 1.5em;
            text-align: center;
        }

        div#controls p.instructions {
            text-align: left;
            margin-bottom: 1em;
            font-family: Helvetica-LightOblique, Helvetica, sans-serif;
            font-style: oblique;
            font-size: 1.25em;
            color: #777776;
        }

        div#controls div#info #client-name {
            text-align: left;
            margin-bottom: 1em;
            font-family: "Helvetica Light", Helvetica, sans-serif;
            font-size: 1.25em;
            color: #777776;
        }

        div#controls button {
            width: 15em;
            height: 2.5em;
            margin-top: 1.75em;
            border-radius: 1em;
            font-family: "Helvetica Light", Helvetica, sans-serif;
            font-size: .8em;
            font-weight: lighter;
            outline: 0;
        }

        div#controls button:active {
            position: relative;
            top: 1px;
        }

        div#controls div#call-controls {
            display: none;
        }

        div#controls div#call-controls input {
            font-family: Helvetica-LightOblique, Helvetica, sans-serif;
            font-style: oblique;
            font-size: 1em;
            width: 100%;
            height: 2.5em;
            padding: .5em;
            display: block;
        }

        div#controls div#call-controls button {
            color: #fff;
            background: 0 0;
            border: 1px solid #686865;
        }

        div#controls div#call-controls button#button-hangup {
            display: none;
        }

        div#controls div#log {
            border: 1px solid #686865;
            width: 35%;
            height: 9.5em;
            margin-top: 2.75em;
            text-align: left;
            padding: 1.5em;
            float: right;
            overflow-y: scroll;
        }

        div#controls div#log p {
            color: #686865;
            font-family: 'Share Tech Mono', 'Courier New', Courier, fixed-width;
            font-size: 1.25em;
            line-height: 1.25em;
            margin-left: 1em;
            text-indent: -1.25em;
            width: 90%;
        }
    </style>
</head>
<body>
<div id="controls">
    <div id="info">
        <p class="instructions">Twilio Client</p>
        <div id="client-name"></div>
    </div>
    <div id="call-controls">
        <p class="instructions">Make a Call:</p>
        <input id="phone-number" type="text" placeholder="Enter a phone # or client name" />
        <button id="button-call">Call</button>
        <button id="button-hangup">Hangup</button>
    </div>
    <div id="log"></div>
</div>

<script type="text/javascript" src="//media.twiliocdn.com/sdk/js/client/v1.7/twilio.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
  $(function () {
    log('Requesting Capability Token...');
    $.getJSON('/laravel-twilio/voice/token')
     .done(function (data) {
       log('Got a token.');
       console.log('Token: ' + data.token);

       // Setup Twilio.Device
       Twilio.Device.setup(data.token);

       Twilio.Device.ready(function (device) {
         log('Twilio.Device Ready!');
         document.getElementById('call-controls').style.display = 'block';
       });

       Twilio.Device.error(function (error) {
         log('Twilio.Device Error: ' + error.message);
       });

       Twilio.Device.connect(function (conn) {
         log('Successfully established call!');
         document.getElementById('button-call').style.display = 'none';
         document.getElementById('button-hangup').style.display = 'inline';
       });

       Twilio.Device.disconnect(function (conn) {
         log('Call ended.');
         document.getElementById('button-call').style.display = 'inline';
         document.getElementById('button-hangup').style.display = 'none';
       });

       Twilio.Device.incoming(function (conn) {
         log('Incoming connection from ' + conn.parameters.From);
         var archEnemyPhoneNumber = '+12099517118';

         if (conn.parameters.From === archEnemyPhoneNumber) {
           conn.reject();
           log('It\'s your nemesis. Rejected call.');
         } else {
           // accept the incoming connection and start two-way audio
           conn.accept();
         }
       });

       setClientNameUI(data.identity);
     })
     .fail(function () {
       log('Could not get a token from server!');
     });

    // Bind button to make call
    document.getElementById('button-call').onclick = function () {
      // get the phone number to connect the call to
      var params = {
        To: document.getElementById('phone-number').value
      };

      console.log('Calling ' + params.To + '...');
      Twilio.Device.connect(params);
    };

    // Bind button to hangup call
    document.getElementById('button-hangup').onclick = function () {
      log('Hanging up...');
      Twilio.Device.disconnectAll();
    };

  });

  // Activity log
  function log(message) {
    var logDiv = document.getElementById('log');
    logDiv.innerHTML += '<p>&gt;&nbsp;' + message + '</p>';
    logDiv.scrollTop = logDiv.scrollHeight;
  }

  // Set the client name in the UI
  function setClientNameUI(clientName) {
    var div = document.getElementById('client-name');
    div.innerHTML = 'Your client name: <strong>' + clientName +
        '</strong>';
  }
</script>
</body>
</html>