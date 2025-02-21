@extends('layouts.sandbox')
@section('title', __('locale.titles.sandbox'))

@section('page_styles')
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <!-- DataTables Buttons CSS -->
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">

  <style>
    .sandbox-area {
      /* background: #222;*/
      min-height: 20vh;
      max-height: 50vh;
      overflow-y: scroll;
      border-radius: 1rem;
      animation: animate-border 3s linear infinite;
      position: relative;
    }

    .chat-bubble {
      max-width: 75%;
      padding: .5rem .7rem;
      border-radius: 1rem;
      margin-bottom: .5rem;
      font-size: 14px;
      word-wrap: break-word;
    }

    /* System Message */
    .system {
      background-color: #e9ecef;
      color: #333;
      text-align: left;
      border-top-left-radius: 0;
      align-self: flex-start;
    }

    /* Error Message */
    .neutral {
      background-color: #dfdfdf;
      color: #111;
      text-align: center;
      margin-left: auto;
      margin-right: auto;
      border: 1px solid #aaa;
    }

    /* User Message */
    .user {
      background-color: #007bff;
      color: white;
      text-align: right;
      border-top-right-radius: 0;
      align-self: flex-end;
      margin-left: auto;
    }

    /* Error Message */
    .error {
      background-color: #b30000;
      color: white;
      text-align: left;
      border-top-left-radius: 0;
      align-self: flex-start;
    }
  </style>

@endsection

@section('content')
  {{-- <div class="container text-center mt-4">
    <div class="row g-4">
      <div class="col">
        <button class="btn btn-outline-primary btn-lg" data-bs-toggle="tab" data-bs-target="#transaction-tab">
          Make Transaction
        </button>
      </div>
      <div class="col">
        <button class="btn btn-outline-primary btn-lg" data-bs-toggle="tab" data-bs-target="#topup-tab">
          Make TopUp
        </button>
      </div>
    </div>
  </div>

  <section class="row justify-content-center mt-4 bg-dark p-4">
    <div class="col-11 col-md-8 col-lg-6 p-3 card">
      <div class="tab-content">
        <!-- Transaction Tab Content -->
        <div class="tab-pane fade show active" id="transaction-tab">
          <div class="p-3">
            <h5 class="text-primary">Transaction Details</h5>
            <p>Enter transaction details here...</p>
          </div>
          <div class="row justify-content-center">
            <button class="col-12 col-sm-4 col-md-3 col-lg-2 btn btn-primary">Send</button>
          </div>
        </div>

        <!-- TopUp Tab Content -->
        <div class="tab-pane fade" id="topup-tab">
          <div class="p-3">
            <h5 class="text-primary">TopUp Details</h5>
            <p>Enter top-up details here...</p>
          </div>
          <div class="row justify-content-center">
            <button class="col-12 col-sm-4 col-md-3 col-lg-2 btn btn-primary">Send</button>
          </div>
        </div>
      </div>
    </div>
  </section> --}}

  <div class="container text-center">
    <div class="row g-4 nav text-center">
      <div class="col mt-1">
        <button class="active btn btn-outline-primary border border-primary" id="register-tab" data-bs-toggle="tab"
          data-bs-target="#register-content" type="button" role="tab" aria-controls="register-content"
          aria-selected="true">
          Register User
        </button>
      </div>
      <div class="col mt-1">
        <button class="btn btn-outline-success border border-success" id="transaction-tab" data-bs-toggle="tab"
          data-bs-target="#transaction-content" type="button" role="tab" aria-controls="transaction-content"
          aria-selected="false">
          Transact
        </button>
      </div>
    </div>
  </div>

  <section class="row justify-content-center mt-4 bg-dark p-2 p-md-4">
    <div class="col-12 col-md-10 col-lg-6 p-2 card">
      <div class="tab-content">

        <!-- TopUp Tab Content -->
        <div class="tab-pane fade show active" id="register-content" role="tabpanel" aria-labelledby="register-tab">
          <div class="p-3 pb-1 sandbox-register-area">
            <p class="chat-bubble neutral">Click on <span class="badge badge-sm bg-primary ">Start Registration</span>
              below.</p>
          </div>
          <div id="start-register-div" class="input-group mt-3">
            <button class="btn btn-primary mx-auto" id="start-register">Start Registration</button>
          </div>
          <div id="send-register-div" class="input-group mt-3 d-none">
            <input type="text" id="register-input" class="form-control" placeholder="Enter your response">
            <button class="btn btn-primary" id="send-register">Send</button>
          </div>
        </div>


        <!-- Transaction Tab Content -->
        <div class="tab-pane fade" id="transaction-content" role="tabpanel" aria-labelledby="transaction-tab">
          <div class="p-3 pb-1 sandbox-transact-area">
            <p class="chat-bubble neutral">Click on <span class="badge badge-sm bg-success ">Begin</span> below.</p>
          </div>
          <div id="start-transaction-div" class="input-group mt-3">
            <button class="btn btn-success mx-auto" id="start-transaction">Run</button>
          </div>
          <div id="send-transaction-div" class="input-group mt-3 d-none">
            <input type="text" id="transaction-input" class="form-control" placeholder="Enter your response">
            <button class="btn btn-primary" id="send-transaction">Send</button>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection


@section('page_script')

  <!-- jQuery (required for DataTables) -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

  <!-- DataTables Buttons JS -->
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


  {{-- // Pusher  --}}
  {{-- <script src="https://js.pusher.com/8.2/pusher.min.js"></script> --}}
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.2/dist/echo.iife.js"></script>

  <script type="module">
    $(document).ready(function() {
      // Initialize Pusher
      // Pusher.logToConsole = true;

      // window.Echo = new Echo({
      //   broadcaster: 'pusher',
      //   key: '{{ env('PUSHER_APP_KEY') }}',
      //   cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
      //   forceTLS: '{{ env('PUSHER_SCHEME', 'https') === 'https' }}'
      // });

      // Listen for events
      // window.Echo.channel('ussd-channel')
      //   .listen('.UssdResponseReceived', (data) => {
      //     console.log('Received:', data);
      //     $(".sandbox-area").append("<p> *** " + data.message.message + " *** </p>");
      //   });

      let sessionID = Date.now().toString();

      // Start Registeration (First Request without User Input)
      $('#start-register').on('click', function() {
        $(this).prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', 'disabled')
        let requestData = {
          sessionID: sessionID,
          userID: '{{ Auth::user()->id }}',
          newSession: true, // New session
          msisdn: '0241076475', //'{{ Auth::user()->phone }}',
          userData: '*928*1#', // First request without user input
          network: '{{ Auth::user()->network }}'
        };

        $(".sandbox-register-area").find(".user, .system, .error").each(function() {
          $(this).fadeOut(300, function() {
            $(this).remove();
          });
        });
        sendUSSDRegistration(requestData);
      });

      $('#send-register').on('click', function() {
        let userInput = $('#register-input').val().trim();
        if (userInput === '') return;

        $(this).prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', 'disabled')

        let requestData = {
          sessionID: sessionID,
          userID: '{{ Auth::user()->id }}',
          newSession: false,
          msisdn: '0241076475', //{{ Auth::user()->phone }},
          userData: userInput,
          network: '{{ Auth::user()->network }}'
        };
        // Append user message
        $(".sandbox-register-area").append("<p class='chat-bubble user'>" + userInput + "</p>");
        $('#user-input').val(''); // Clear input field
        sendUSSDRegistration(requestData);
        $(this).prop('disabled', false).find('.fa-spinner').remove();
      });

      // ======================================================
      // Begin Transaction (First Request without User Input)
      $('#start-transaction').on('click', function() {
        $(this).prepend('<i class="fa fa-spinner fa-spin"></i> ').prop('disabled', 'disabled')
        let requestData = {
          sessionID: sessionID,
          userID: '{{ Auth::user()->id }}',
          newSession: true, // New session
          msisdn: '{{ Auth::user()->phone }}',
          userData: '1', // First request without user input
          network: '{{ Auth::user()->network }}'
        };

        if (requestData.newSession == true) {
          $(".sandbox-transact-area").find(".user, .system, .error").fadeOut(300, function() {
            $(this).remove();
          });
        }

        sendUSSDTransaction(requestData);

      });

      // Subsequent Transactions (Require User Input)
      $('#send-transaction').on('click', function() {
        let userInput = $('#transaction-input').val().trim();
        let requestData = {
          sessionID: sessionID,
          userID: '{{ Auth::user()->id }}',
          newSession: false,
          msisdn: '{{ Auth::user()->phone }}',
          userData: userInput,
          network: '{{ Auth::user()->network }}'
        };

        if (userInput === '') return;

        // Append user message
        $(".sandbox-transaction-area").append("<p class='chat-bubble user'>" + userInput + "</p>");
        $('#user-input').val(''); // Clear input field

        sendUSSDTransaction(requestData);
        $(this).prop('disabled', false).find('.fa-spinner').remove();
      });

      // Function to Send AJAX Request
      function sendUSSDTransaction(requestData) {
        $.ajax({
          url: "{{ route('api.handle-ussd-transaction') }}",
          type: "POST",
          data: requestData,
          dataType: "json",
          success: function(response) {
            console.log("Responsezzzz:", response);
            setTimeout(() => {
              $(".sandbox-transact-area").append("<p class='chat-bubble system'>" + response.message +
                "</p>");
              // $(".chat-container").scrollTop($(".chat-container")[0].scrollHeight);
            }, 500); // Simulate delay
            if (response.continueSession == true) {
              $('#start-transaction-div').hide(300)
              $('#send-transaction-div').removeClass('d-none').show(300)
            } else {
              $('#start-transaction').html('Rerun Simulation').removeAttr('disabled').show(300)
              $('#send-transaction-div').addClass('d-none').hide(300)
              $('#start-transaction-div').show(300)
            }
          },
          error: function(xhr, status, error) {
            console.error("Error:", error);
            setTimeout(() => {
              $(".sandbox-transaction-area").append(
                "<div class='chat-bubble system-message error'>Failed to process request</div>");
              // $(".chat-container").scrollTop($(".chat-container")[0].scrollHeight);
            }, 500);
          }
        });
      }

      function sendUSSDRegistration(requestData) {
        $.ajax({
          url: "{{ route('api.handle-ussd-registration') }}",
          type: "POST",
          data: requestData,
          dataType: "json",
          success: function(response) {
            console.log("Registration Response:", response);
            setTimeout(() => {
              $(".sandbox-register-area").append("<p class='chat-bubble system'>" + response.message +
                "</p>");
            }, 500);
            if (response.continueSession == true) {
              $('#start-register-div').hide(300)
              $('#send-register-div').removeClass('d-none').show(300)
            } else {
              $('#start-register').html('Rerun Simulation').removeAttr('disabled').show(300)
              $('#send-register-div').addClass('d-none').hide(300)
              $('#start-register-div').show(300)
            }
          },
          error: function(xhr, status, error) {
            console.error("Error:", error);
            setTimeout(() => {
              $(".sandbox-register-area").append(
                "<div class='chat-bubble system-message error'>Failed to process request</div>");
              // $(".chat-container").scrollTop($(".chat-container")[0].scrollHeight);
            }, 500);
          }
        });
      }
    });
  </script>

@endsection
